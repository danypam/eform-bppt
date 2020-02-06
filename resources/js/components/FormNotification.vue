<template>

    <li class="dropdown">
        <a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
            <i class="lnr lnr-alarm"></i>
            <span class="badge bg-danger" id="count-notification">{{submissions.length}}</span>
        </a>
        <ul class="dropdown-menu notifications">
            <li><a href="/inbox" class="notification-item"><span class="dot bg-success" v-for="submission in submissions">{{submission.data}}</span></a></li>

            <li><a href="/inbox" class="more">See all notifications</a></li>

            <li><p class="more" v-if="submissions.length==0">No Notification</p></li>
        </ul>
    </li>

</template>

<script>
    export default {
        props: ['submissions'],
    };
</script>

<!--<style scoped>-->

<!--</style>-->
