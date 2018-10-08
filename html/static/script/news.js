require([
    'vue',
    'jquery',
    'footerComponent',
    'jqueryCookie',
    'jqueryWeui'
], function (Vue,$, footerComponent) {
    new Vue({
        el: '#app',
        data: {
            news_list_data:"",
        },
        mounted: function () {
            this.datalist();
        },
        methods: {
            datalist:function(){
                var _this = this;
                $.ajax({
                    url: '/Home/category/ajax_getNewsList',
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        _this.news_list_data = data;

                    }
                })
            }
        }
    })
});