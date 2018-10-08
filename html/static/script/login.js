require([
    'vue',
    'jquery',
    'jqueryWeui',
], function (Vue,$) {
    new Vue({
        el:'#app',
        data:{
            alertStatus:false,
            countdown:60,
            loadText:'Get verification code | 获取验证码',
            status: false,
            user_type:'',
            phone:'',
            code:'',
        },

        methods: {
            countDown: function () {
                var self = this;
                if (self.countdown == 0) {
                    self.status = false;
                    self.loadText = "Get verification code | 获取验证码";
                    self.countdown = 60;
                } else {
                    self.status = true;
                    self.loadText = self.countdown+'s';
                    self.countdown--;
                    setTimeout(function() {
                        self.countDown();
                    }, 1000);
                }
            },
            getSms: function (el) {

                var self = this;
                if(self.status){
                    return false;
                }

                if(!/^1[345678]\d{9}$/.test(self.phone)){
                    $.toptip('手机号码输入错误', 'error');
                    return false;
                }
                $.showLoading('数据加载中');
                $.ajax({
                    url: '/Home/member/ajax_send_verify_code',
                    type: 'post',
                    dataType: 'json',
                    data:{
                        mobile: self.phone
                    },
                    timeout:10000,
                    async:false,
                    success: function (data) {
                        $.hideLoading();
                        if(data.status == 1){
                            self.countDown();
                        }else if(data.status == 0){
                            $.toptip(data.info);
                        }

                    },
                    error: function (data) {
                    	console.log(data);
                        $.hideLoading();
                        $.toptip('数据请求失败,请重试','error');
                    }
                })

            },
            submit: function () {
                var self =  this;
                if(!/^1[345678]\d{9}$/.test(self.phone)){
                    $.toptip('手机号码输入错误', 'error');
                    return false;
                }
                if(!self.code){
                    $.toptip('验证码输入错误', 'error');
                    return false;
                }
                $.showLoading('数据加载中');
                $.ajax({
                    url:'/Home/member/ajax_login',
                    data:{
                        mobile: self.phone,
                        verify_code: self.code,
                        user_type:0
                    },
                    type: 'post',
                    dataType: 'json',
                    timeout:10000,
                    async:false,
                    success: function (data) {
                        $.hideLoading();
                        if(data.status == 0){
                            $.toptip(data.info);
                        }else{
                            if (Number(data.uid) != 0) {
                                // var m = document.referrer;
                                window.location.href = '/index.php?s=/home/member/personal';
                            }
                        }

                    },
                    error: function (data) {
                        $.hideLoading();
                        $.toptip('数据请求失败,请重试','error');
                    }
                })
            },
        }
    })
});