require([
    'vue',
    'footerComponent',
    'jqueryCookie',
    'jqueryWeui'
], function (Vue,footerComponent) {
    new Vue({
        el:'#app',
        data:{
            news_detail_data:"",
            last:true,
            next:true
        },
        mounted: function () {
            this.news_detail(0);

        },
        methods: {
            getUrlParms: function (name) {
                var parmsStr = window.location.search;
                var parmsArr = parmsStr.split('&')
                var parms = {}
                for (var i = 0; i < parmsArr.length; i++) {
                    parms[parmsArr[i].split('=')[0]] = parmsArr[i].split('=')[1]
                }
                return parms[name]
            },
            news_detail_Last:function(m){
                var _this = this;
                _this.next = true;
                if (_this.last){
                    _this.news_detail(m);
                }

            },
            news_detail_Next: function (m) {
                var _this = this;
                _this.last = true;
                if (_this.next) {
                    _this.news_detail(m);
                }

            },
            news_detail:function(m){
                var _this = this;
                $.ajax({
                    url: '/Home/category/ajax_getNextNews',
                    type: 'post',
                    data:{
                        id: _this.getUrlParms('id'),
                        dir:m,
                    },
                    dataType: 'json',
                    success: function (data) {
                        if(m == 0){
                            _this.news_detail_data = data;
                            history.pushState({}, 0, '/index.php?s=/home/index/news_detail.html&id=' + data.id);

                        }else{
                            if (data != null) {
                                $.showLoading('数据加载中');
                                setTimeout(function () {
                                    $.hideLoading();
                                    _this.news_detail_data = data;
                                    history.pushState({}, 0, '/index.php?s=/home/index/news_detail.html&id=' + data.id);

                                }, 800)
                            } else {
                                if (m == 1) {
                                    $.toptip('没有下一篇了 | NO Next');
                                    _this.next = false;
                                } else {
                                    $.toptip('没有上一篇了 | NO Last');
                                    _this.last = false;
                                }

                            }
                        }


                    }
                })
            },
        }
    })
});