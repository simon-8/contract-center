
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//import ElementUI from 'element-ui';
import {
    Pagination,
    Dialog,
    Autocomplete,
    Dropdown,
    DropdownMenu,
    DropdownItem,
    Menu,
    Submenu,
    MenuItem,
    MenuItemGroup,
    Input,
    InputNumber,
    Radio,
    RadioGroup,
    RadioButton,
    Checkbox,
    CheckboxButton,
    CheckboxGroup,
    Switch,
    Select,
    Option,
    OptionGroup,
    Button,
    ButtonGroup,
    Table,
    TableColumn,
    DatePicker,
    TimeSelect,
    TimePicker,
    Popover,
    Tooltip,
    Breadcrumb,
    BreadcrumbItem,
    Form,
    FormItem,
    Tabs,
    TabPane,
    Tag,
    Tree,
    Alert,
    Slider,
    Icon,
    Row,
    Col,
    Upload,
    Progress,
    Badge,
    Card,
    Rate,
    Steps,
    Step,
    Carousel,
    CarouselItem,
    Collapse,
    CollapseItem,
    Cascader,
    ColorPicker,
    Transfer,
    Container,
    Header,
    Aside,
    Main,
    Footer,
    Loading,
    MessageBox,
    Message,
    Notification
} from 'element-ui';

Vue.use(Pagination);
//Vue.use(Dialog);
//Vue.use(Autocomplete);
//Vue.use(Dropdown);
//Vue.use(DropdownMenu);
//Vue.use(DropdownItem);
Vue.use(Menu);
Vue.use(Submenu);
Vue.use(MenuItem);
Vue.use(MenuItemGroup);
//Vue.use(Input);
//Vue.use(InputNumber);
//Vue.use(Radio);
//Vue.use(RadioGroup);
//Vue.use(RadioButton);
//Vue.use(Checkbox);
//Vue.use(CheckboxButton);
//Vue.use(CheckboxGroup);
//Vue.use(Switch);
//Vue.use(Select);
//Vue.use(Option);
//Vue.use(OptionGroup);
Vue.use(Button);
Vue.use(ButtonGroup);
Vue.use(Table);
Vue.use(TableColumn);
//Vue.use(DatePicker);
//Vue.use(TimeSelect);
//Vue.use(TimePicker);
//Vue.use(Popover);
//Vue.use(Tooltip);
//Vue.use(Breadcrumb);
//Vue.use(BreadcrumbItem);
//Vue.use(Form);
//Vue.use(FormItem);
//Vue.use(Tabs);
//Vue.use(TabPane);
Vue.use(Tag);
//Vue.use(Tree);
//Vue.use(Alert);
//Vue.use(Slider);
Vue.use(Icon);
Vue.use(Row);
Vue.use(Col);
//Vue.use(Upload);
//Vue.use(Progress);
//Vue.use(Badge);
Vue.use(Card);
//Vue.use(Rate);
//Vue.use(Steps);
//Vue.use(Step);
//Vue.use(Carousel);
//Vue.use(CarouselItem);
//Vue.use(Collapse);
//Vue.use(CollapseItem);
//Vue.use(Cascader);
//Vue.use(ColorPicker);
Vue.use(Container);
Vue.use(Header);
Vue.use(Aside);
Vue.use(Main);
Vue.use(Footer);

Vue.use(Loading.directive);

Vue.prototype.$loading = Loading.service;
//Vue.prototype.$msgbox = MessageBox;
//Vue.prototype.$alert = MessageBox.alert;
//Vue.prototype.$confirm = MessageBox.confirm;
//Vue.prototype.$prompt = MessageBox.prompt;
//Vue.prototype.$notify = Notification;
Vue.prototype.$message = Message;

import 'element-ui/lib/theme-chalk/index.css';
//Vue.use(ElementUI);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import App from './App.vue';
import router from './router/index.js';
import store from './store.js';
import helperPlugin from './utils/helperPlugin.js';

// 注册全局插件
Vue.use(helperPlugin);

// 注册全局组件
Vue.component('Tag', require('./components/TagComponent'));
Vue.component('Project', require('./components/ProjectComponent'));

//router.beforeEach((to, from, next) => {
//    /* 路由发生变化修改页面title */
//    if (to.meta.title) {
//        document.title = to.meta.title;
//    }
//    next();
//});

const app = new Vue({
    el: '#app',
    router,
    store,
    template: '<App/>',
    components: { App }
});
// 载入App组件并替换#app为App标签
// 相当于 app.js中  Vue.component('App', require('./components/App.vue'));
// 然后vue页面中 <div id="app"><App></App></div>