Nova.booting((Vue, router, store) => {
  Vue.component('index-shortcode-text', require('./components/IndexField'))
  Vue.component('detail-shortcode-text', require('./components/DetailField'))
  Vue.component('form-shortcode-text', require('./components/FormField'))
})
