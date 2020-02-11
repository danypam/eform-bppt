<template>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
            <i class="lnr lnr-alarm"></i>
            <span class="badge bg-danger" id="count-notification">{{unreadNotifications.length}}</span>
        </a>
        <ul class="dropdown-menu notifications">
            <li><a  v-for="unread in unreadNotifications" href="#" v-on:click="MarkAsRead(unread)" class="notification-item"><span class="dot bg-success" >{{unread.data.submission.form_id}} submited by {{unread.data.submission.user_id}}</span></a></li>
            <li><p class="more" v-if="unreadNotifications.length==0">No Notification</p></li>
        </ul>
    </li>

</template>

<script>
    export default {
        props: ['unreads','userid'],
        data(){
            return {
                unreadNotifications: this.unreads
            }
        },
        methods : {
            MarkAsRead: function (unread) {
              var data= {
                  not_id : unread.id,
                  submission_id : unread.data.submission.id,
              };
                axios.post("/markAsRead",data).then(response => {
                  window.location.href="/read/" +data.submission_id;
              })
            },


        },mounted() {
            console.log('component mounted')
            Echo.private('App.User.' + this.userid)
                .notification((notification)=> {
                    console.log(notification);
                    let newUnreadNotifications={data:{submission:notification.submission,user:notification.user}};
                    this.unreadNotifications.push(newUnreadNotifications);
                });
        }
    };
</script>

<!--<style scoped>-->

<!--</style>-->
