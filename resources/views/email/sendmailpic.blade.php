
<html>
<head>
    <style>
        .banner-color {
            background-color: #3D6EC9;
        }
    </style>
</head>
<body>
<div style="background-color:#ffffff;padding:0;margin:0 auto;font-weight:200;width:100%!important">
    <table align="center" border="0" cellspacing="0" cellpadding="0" style="table-layout:fixed;font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
        <tbody>
        <tr>
            <td align="center">
                <center style="width:100%">
                    <table bgcolor="#f5fcff" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto;max-width:950px;font-weight:200;width:inherit;font-family:Helvetica,Arial,sans-serif" width="512">
                        <tbody>
                        <tr>
                            <td bgcolor="#72868f" width="100%" style="background-color:#f3f3f3;padding:12px;border-bottom:1px solid #ececec">
                                <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;width:100%!important;font-family:Helvetica,Arial,sans-serif;min-width:100%!important" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left" valign="middle" width="50%"><div style="margin:0;color:black;white-space:normal;display:inline-block;text-decoration:none;font-size:16px;line-height:20px"><img src="https://66.media.tumblr.com/3730510473163ee1f293ddabe1648e42/451a7dd054f0687b-23/s250x400/091da9ce2e8d0f1c4cec39c77c16f0ca19f67573.png" width="100%"></div></td>
                                        <td valign="middle" width="50%" align="right" style="padding:0 0 0 10px"><span style="margin:0;color:#4c4c4c;white-space:normal;display:inline-block;text-decoration:none;font-size:12px;line-height:20px"></span></td>
                                        <td width="1">&nbsp;</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                    <tbody>
                                    <tr>
                                        <td width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" bgcolor="#3D6EC9" style="padding:20px 48px;color:#ffffff" class="banner-color">
                                                        <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                            <tbody>
                                                            <tr>
                                                                <td align="center" width="100%">
                                                                    <h1 style="padding:0;margin:0;color:#ffffff;font-weight:500;font-size:20px;line-height:20px">Anda memiliki permohonan yang harus dikerjakan!</h1>
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="padding:20px 0 10px 0">
                                                        <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                            <tbody>
                                                            <tr>
                                                                <td align="center" width="100%" style="padding: 0 15px;text-align: justify;color: rgb(76, 76, 76);font-size: 12px;line-height: 18px;">
                                                                    <img src="https://66.media.tumblr.com/96298dc1158e944fb1e519cb02818770/70bdf9d7e190cc98-28/s1280x1920/aa659bdffce2049873132bcd08d4d80d06c5a679.png" width="100%"><br><br>
                                                                    <h3 style="font-weight: 600; padding: 0px; margin: 0px; font-size: 16px; line-height: 24px; text-align: center;" class="title-color">Halo, {{$detail['name']}}</h3>
                                                                    <p style="margin: 20px 0 30px 0;font-size: 15px;text-align: center;">Tekan tombol di bawah ini apabila ingin mengerjakan</p>
                                                                    <center><a href="{{$detail['url']}}" style="background-color: #3D6EC9; border-radius:40px; color: #ffffff; padding: 10px; font-size: 16px;margin: 20px 0 30px 0;display: inline-block; font-weight: bold; text-decoration:none; border: none;cursor: pointer;">Tugas Saya</a></center>
                                                                    <p style="margin: 20px 0 30px 0;font-size: 15px;text-align: center;">Berikut data permohonan yang perlu dikerjakan</p>

                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                </tr>
                                                <tr>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table bgcolor="#f5fcff" border="0" cellspacing="0" cellpadding="0" style="padding:0 24px;color:#999999;font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" valign="middle" width="100%" style="border-top:1px solid #d9d9d9;padding:12px 0px 20px 0px;text-align:left;color:#4c4c4c;font-weight:200;font-size:17px;line-height:18px"><br><b style="color: #043152"><center>Permohonan #{{ $detail['submission']->id }} dari formulir '{{ $detail['submission']->form->name }}'</center></b><br><br>

                                                        <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif;font-size:15px;" width="100%">
                                                            <tbody style="border: none">
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Nama Lengkap</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word; text-indent: 2%; width: 50%">{{$detail['identitas']->nama_lengkap}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Email</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word;text-indent: 2%; width: 50%">{{$detail['identitas']->email}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>NIP</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word; text-indent: 2%;width: 50%">{{$detail['identitas']->nip}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Kerja</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word; text-indent: 2%;width: 50%">{{$detail['identitas']->unit_kerja->unit}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Unit Jabatan</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word; text-indent: 2%;width: 50%">{{$detail['identitas']->unit_jabatan->unit}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>No HP</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;word-wrap: break-word; text-indent: 2%;width: 50%">{{$detail['identitas']->no_hp}}</td>
                                                            </tr>
                                                            {{--                                        --}}
                                                            @foreach($detail['form_headers'] as $header)
                                                                <tr>
                                                                    <td style="border: none;word-wrap: break-word; width: 50%"><strong>{{ $header['label'] ?? title_case($header['name']) }} </strong></td>
                                                                    <td>:</td>
                                                                    <td  style="border: none;word-wrap: break-word;text-indent: 2%; width: 50%" class="float-right"><span>{{ $detail['submission']->renderEntryContent($header['name'], $header['type']) }}</span></td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="padding:0 0 8px 0" width="100%"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table bgcolor="#f5fcff" border="0" cellspacing="0" cellpadding="0" style="padding:0 24px;color:#999999;font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="left" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="left" valign="middle" width="100%" style="border-top:1px solid #d9d9d9;padding:12px 0px 20px 0px;text-align:left;color:#4c4c4c;font-weight:200;font-size:16px;line-height:18px"><br><b style="color: #043152">Detail</b><br><br>
                                                        <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif; font-size:15px;" width="100%">
                                                            <tbody style="border: none">
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Jenis Form</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{$detail['submission']->form->name}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Dibuat oleh</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{$detail['submission']->user->name ?? 'Guest' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Waktu Pembuatan</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{$detail['submission']->updated_at->toDayDateTimeString()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Terakhir Diperbarui</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{$detail['submission']->created_at->toDayDateTimeString()}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Diketahui oleh</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap)? \App\Http\Controllers\FormController::getNamePic($detail['submission']->mengetahui)->nama_lengkap:'' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Waktu Diketahui</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{ isset($detail['submission']->mengetahui_at)? $detail['submission']->mengetahui_at: '' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Disetujui oleh</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{ isset(\App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap) ? \App\Http\Controllers\FormController::getNamePic($detail['submission']->menyetujui)->nama_lengkap: ''}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border: none;word-wrap: break-word; width: 50%"><strong>Waktu Disetujui</strong></td>
                                                                <td>:</td>
                                                                <td style="border: none;text-indent: 2%;word-wrap: break-word; width: 50%">{{ isset($detail['submission']->menyetujui_at)? $detail['submission']->menyetujui_at: ''}}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="padding:0 0 8px 0" width="100%"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <table bgcolor="#f5fcff" border="0" cellspacing="0" cellpadding="0" style="padding:0 24px;color:#999999;font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                    <tbody>
                                    <tr>
                                        <td align="center" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" valign="middle" width="100%" style="border-top:1px solid #d9d9d9;padding:12px 0px 20px 0px;text-align:center;color:#4c4c4c;font-weight:200;font-size:14px;line-height:18px"><br><b>Terimakasih</b>

                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" width="100%">
                                            <table border="0" cellspacing="0" cellpadding="0" style="font-weight:200;font-family:Helvetica,Arial,sans-serif" width="100%">
                                                <tbody>
                                                <tr>
                                                    <td align="center" style="padding:0 0 8px 0" width="100%"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </center>
            </td>
        </tr>
        </tbody>
    </table>
</div>
