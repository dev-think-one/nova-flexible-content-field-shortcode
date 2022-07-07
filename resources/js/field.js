import IndexField from './components/IndexField'
import DetailField from './components/DetailField'
import FormField from './components/FormField'

Nova.booting((app, store) => {
    app.component('index-shortcode-text', IndexField)
    app.component('detail-shortcode-text', DetailField)
    app.component('form-shortcode-text', FormField)
})
