require([
    'vue',
    'swiper',
    'jquery',
    'footerComponent',
    'jqueryWeui',
    'jqueryCookie'
], function (Vue, Swiper, $, footerComponent) {
    Vue.prototype.msg = function (num) {
        var html = "";
        for (var i = 0; i < num; i++) {
            html += "<span></span>";
        }
        return html;
    };
    new Vue({
        el: '#app',
        data: {
            menu_sidebar: 1,
            stores: [],
            stores_detail: "",
            menu_data: [],
            video_data: [],
            checkAlert: false,
        },
        mounted: function () {
            this.menu();
        },
        methods: {
            nav_menu_sidebar: function (m) {
                var _this = this;
                _this.menu_sidebar = m;
                $('body,html').animate({
                    scrollTop: 0
                }, 100);
            },
            menu: function () {
                var _this = this;
                $.ajax({
                    url: '/Home/category/ajax_getMenuList',
                    type: 'post',
                    dataType: 'json',
                    success: function (data) {
                        _this.menu_data = data;

                    }
                })
            },
            sidebar_link: function (m) {
                window.location.href = '/index.php?s=/home/index/shop_detail.html&id=' + m;
            },
            checkPicture: function (d) {
                var _this = this;
                _this.checkAlert = true;
                _this.initSwiper(d)

            },
            initSwiper: function (d) {
                new Swiper('#menuBigImg', {
                    initialSlide: Number(d),
                    freeMode: false,
                    slidesPerView: 'auto',
                    observer: true,
                    observeParents: true
                });
            },
        }
    })
});
