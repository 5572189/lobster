require([
    'vue',
    'swiper',
    'jquery',
    'footerComponent',
    'jqueryWeui',
    'jqueryCookie'

], function (Vue, Swiper, $, footerComponent) {
    new Vue({
        el: '#app',
        data: {
            messageData:"",
        },
        mounted: function () {
            this.message()
        },
        methods: {
            message:function(){
                var _this = this;
                $.ajax({
                    url:'/Home/member/ajax_member_info',
                    type: 'post',
                    dataType: 'json',
                    timeout: 10000,
                    async: false,
                    success: function (data) {
                        _this.messageData = data;
                    }
                })
            }
        }
    })
});