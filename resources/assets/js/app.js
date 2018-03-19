/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

require('./google-maps');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));



Rx.DOM.ready().subscribe(() => {
    const app = new Vue({
        el: '#app'
    });
});

var isShowFilterBox = true;
window.showFilterBox = ()=>{
    if(isShowFilterBox)
        $('#filter-box').css('bottom','-40rem');
    else
        $('#filter-box').css('bottom','5rem');
    isShowFilterBox = !isShowFilterBox;
};