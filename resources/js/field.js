import IndexField from './components/ShortcodeTextIndexField'
import DetailField from './components/ShortcodeTextDetailField'
import FormField from './components/ShortcodeTextFormField'

Nova.booting((app, store) => {
    app.component('IndexShortcodeText', IndexField)
    app.component('DetailShortcodeText', DetailField)
    app.component('FormShortcodeText', FormField)
})
