<?php
/*--------------------
https://github.com/jazmy/laravelformbuilder
Licensed under the GNU General Public License v3.0
Author: Jasmine Robinson (jazmy.com)
Last Updated: 12/29/2018
----------------------*/
namespace App;

use App\Form;
use App\User;
use App\UnitKerja;
use App\Pegawai;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use  Carbon\Carbon;
/*use Carbon\Carbon;*/

class Submission extends Model
{
	/**
	 * The table name
	 *
	 * @var string
	 */
	protected $table = 'form_submissions';
	//protected $dateFormat='yy-MM-dd HH:mm:ss';
   // protected $dates = ['YY-MM-DD HH:mm:ss','created_at'];


    /**
     * The attributes that are not assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at',
    ];

    /**
     * The attributes that should be casted to another data type
     *
     * @var array
     */
    protected $casts = [
        'content' => 'array',
        'keterangan'=>'array',
    ];

    /**
     * A Submission may belong to a User
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * A Submission belongs to a Form
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }

    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai', 'pegawai_id', 'id');
    }

    /**
     * Get the forms that belong to the provided user
     *
     * @param User $user
     * @return Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getForUser($user)
    {
        return static::where('user_id', $user->id)->with('form')->latest()->paginate(100);
    }

    /**
     * Load the values the user provided in this submission into the json of the form
     * so that when we render the form, the user's previous values are pre-filled
     *
     * @return void
     */
    public function loadSubmissionIntoFormJson(): void
    {
        $submission_content = $this->content;

        $n = collect($this->form->form_builder_array)
            ->map(function ($entry) use ($submission_content) {
                if (
                    !empty($entry['name']) &&
                    array_key_exists($entry['name'], $submission_content)
                ) {
                    // the field has a 'name' which means it is not a header or paragraph
                    // and the user previously have an entry for that field in the $submission_content
                    $current_submitted_val = $submission_content[$entry['name']] ?? '';

                    if ((empty($entry['value']) && empty($entry['values']))) {
                        // for input types that do not get their values from a 'values' array
                        // set the staight 'value' string and move on
                        $entry['value'] = $current_submitted_val;
                    } else if (!empty($entry['values'])) {
                        // this will hold what will think is the value of the 'other' input
                        // in a checkbox-group that allows the 'other' option
                        $otherInputVal = null;

                        // manipulate the values array so we can preselect the entries that
                        // were chosen in the submission we have on file.
                        if (is_array($current_submitted_val)) {
                            $entry['values'] = collect($entry['values'])
                                ->map(function ($v) use ($current_submitted_val) {
                                    // if this value in the 'values' array is in the
                                    // previous selection made by the user in their
                                    // submission, we will add the selected and checked
                                    // flag to the value so that it will be pre-selected
                                    // when we render the form
                                    if (in_array($v['value'], $current_submitted_val)) {
                                        $v['selected'] = true;
                                        $v['checked'] = 'checked';
                                    }

                                    return $v;
                                })
                                ->toArray();
                        }

                        // check if the 'other' input option is available
                        if (!empty($entry['other']) && $entry['other'] === true) {
                            // let's attempt to get the value that was provided via the
                            // 'other' input field of a checkbox-group
                            // get the submitted value that is not part of the 'values'
                            // array for this entry
                            $values_names = collect($entry['values'])
                                ->map(function ($v) {
                                    return $v['value'];
                                })
                                ->toArray();

                            $other = collect($current_submitted_val)
                                ->filter(function ($sv) use ($values_names) {
                                    return !in_array($sv, $values_names);
                                })
                                ->values();

                            $otherInputVal = $other[0] ?? null;
                        }

                        // still set the value on the entry as we have it
                        $entry['value'] = $otherInputVal ?? $current_submitted_val;
                    }
                }

                return $entry;
            });

        $this->form->form_builder_json = $n;
    }

    /**
     * Turn the current value we are trying to display to string we can actually display
     *
     * @param string $key
     * @param string $type the type of the input type that this key belongs to on the form
     * @param boolean $limit_string
     * @return Illuminate\Support\HtmlString
     */
    public function renderEntryContent($key, $type = null, $limit_string = false): HtmlString
    {
        $str = '';

        if (
            !empty($this->content[$key]) &&
            is_array($this->content[$key])
        ) {
            $str = implode(', ', $this->content[$key]);
        } else {
            $str = $this->content[$key] ?? '';
        }

        if ($limit_string) {
            $str = str_limit($str, 20);
        }

        // if the type is 'file' then we have to render this as a link
        if ($type == 'file') {
            $file_link = Storage::url($this->content[$key]);
            $str = "<a href='{$file_link}'>{$str}</a>";
        }

        return new HtmlString($str);
    }

    public static function count_submission()
    {
        $all = Self::get()->count();
        $new = Self::where('status', '0')->get()->count();
        $pending = Self::where('status', '1')->get()->count();
        $waitForPic = Self::where('status', '2')->get()->count();
        $onGoing = Self::where('status', '3')->get()->count();
        $completed = Self::where('status', '4')->get()->count();
        $rejected = Self::where('status', '-1')->get()->count();
        return ['all' => $all, 'new' => $new, 'pending' => $pending, 'onGoing' => $onGoing, 'completed' => $completed, 'rejected' => $rejected, 'waitForPic' => $waitForPic];
    }

    public static function count_form()
    {
        $forms = Form::all();
        $category = [];

        $series[0]['name'] = 'New';
        $series[1]['name'] = 'Pending';
        $series[2]['name'] = 'Wait For Pic';
        $series[3]['name'] = 'On Going';
        $series[4]['name'] = 'Completed';
        $series[5]['name'] = 'Rejected';

        foreach ($forms as $fm) {
            $category[] = $fm->name;
            $series[0]['data'][] = self::where('status', '=', '0')->where('form_id', '=', $fm->id)->get()->count();
            $series[1]['data'][] = self::where('status', '=', '1')->where('form_id', '=', $fm->id)->get()->count();
            $series[2]['data'][] = self::where('status', '=', '2')->where('form_id', '=', $fm->id)->get()->count();
            $series[3]['data'][] = self::where('status', '=', '3')->where('form_id', '=', $fm->id)->get()->count();
            $series[4]['data'][] = self::where('status', '=', '4')->where('form_id', '=', $fm->id)->get()->count();
            $series[5]['data'][] = self::where('status', '=', '-1')->where('form_id', '=', $fm->id)->get()->count();
        }
				// isset($series) ? $series : '';
				// dd($series);
        return ['category' => $category, 'series' => $series];
    }

    public static function count_form2()
    {
        $forms = Form::all();
        $tahun = date('Y');
        $category = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEPT', 'OCT', 'NOV', 'DES'];
				$series = [];
        $i = -1;
        foreach ($forms as $fm) {
            $i++;
            $series[$i]['name'] = $fm->name;
            for ($j = 1; $j < 13; $j++) {
                $series[$i]['data'][] = self::where('form_id', '=', $fm->id)->whereMonth('created_at', '=', $j + 1)->whereYear('created_at', '=', $tahun)->get()->count();
            }
        }
        // dd($series);
        //dd($category);
        return ['series' => $series, 'category' => $category];
    }

    public static function count_form3()
    {
        $forms = Form::all();
        $tahun_akhir = date('Y', strtotime('+5years'));
        $tahun_awal = date('Y', strtotime('-1years'));
        $category = [];
				$series = [];
        $i = -1;
        foreach ($forms as $fm) {
            $i++;
            $series[$i]['name'] = $fm->name;

            for ($j = $tahun_awal; $j < $tahun_akhir; $j++) {
                $category[] = $j;
                $series[$i]['data'][] = self::where('form_id', '=', $fm->id)->whereYear('created_at', '=', $j)->get()->count();
            }
        }
        //dd($series);
        //dd($category);
        return ['series' => $series, 'category' => $category];
    }

    // public static function chart()
    // {
    //     $forms = Submission::with('form:id,name')->select('form_id')->groupBy('form_id')->get();
		// 		$chart = [];
    //     foreach ($forms as $form){
    //         $result = Submission::select(DB::raw('TIMESTAMP(DATE(created_at)) as time, COUNT(form_id) as data'))
    //             ->groupBy('time')
    //             ->where('form_id',$form->form_id)
    //             ->get();
    //         $value = null;
    //         foreach ($result as $r){
    //             $value[] = [$r->time, $r->data];
    //         }
		//
    //             $chart[] = [$form->form->name, $value] ;
    //     }
    //     //dd($chart);
    //     return $chart;
    // }

}
