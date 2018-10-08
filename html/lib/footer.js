define(['vue'], function (Vue) {
    Vue.component('footer-component', {
        template: '<div id="footer" class="clearfix">' +
        '<div class="footer-item"  :class="{active: current == 1}" @click="_click(1)"><span>关于 ABOUT</span></div>' +
        '<div class="footer-item" :class="{active: current == 2}" @click="_click(2)"><span>菜单 MENU</span></div>' +
        // '<div class="footer-item"  @click="_click(3)"><span class="logo"></span></div>' +
        '<div class="footer-item"  @click="_click(3)"><span class="logo_animation"><i class="xiaL"></i><i class="xiaH"></i><i class="xiaR"></i> </span></div>' +
        '<div class="footer-item" :class="{active: current == 4}" @click="_click(4)"><span>门店 STORE</span></div>' +
        '<div class="footer-item" :class="{active: current == 5}" @click="_click(5)"><span>个人 ME</span></div>' +
        '</div>',
        props: ['current'],
        methods:{
            _click: function (t) {
                var arr = {
                    1:'/index.php?s=/home/index/about',
                    2:'/index.php?s=/home/index/menu',
                    3:'/index.php?s=/home/index/index',
                    4:'/index.php?s=/home/index/store',
                    5:'/index.php?s=/home/member/personal'
                };

                _location  = window.location.href;
                if(_location == webHost + arr[t]){
                    return false;
                }
                window.location.href = webHost + arr[t];
            }
        }
    });
});