<template>
    <default-field :field="field" :errors="errors" :show-help-text="showHelpText">
        <template slot="field">
            <div class="relative">
                <code class="font-bold text-sm cursor-pointer" @click="copyToClipboard">{{ shortcode }}</code>
                <transition>
                    <div v-if="copiedFlag"
                         style="right: 110%; top: 0;"
                    class="absolute btn btn-default btn-primary inline-flex items-center pointer-events-none"
                    >
                        Copied!
                    </div>
                </transition>
            </div>
        </template>
    </default-field>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            copiedFlag: false,
            groupKey: this.field.attribute.substr(0, this.field.attribute.indexOf('__'))
        };
    },

    computed: {
        shortcode() {
            return `[${this.field.shortcodeKeyName}="${this.groupKey}"]`;
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            // formData.append(this.field.attribute, this.value || '')
        },

        copyToClipboard() {
            const el = document.createElement('textarea');
            el.value = this.shortcode;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);

            this.copiedFlag = true;
            setTimeout(() => {
                this.copiedFlag = false;
            }, 2000)
        }
    },
}
</script>
