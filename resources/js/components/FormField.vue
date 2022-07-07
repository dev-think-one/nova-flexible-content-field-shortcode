<template>
    <DefaultField :field="field" :errors="errors" :show-help-text="showHelpText">
        <template #field>
            <div class="relative">
                <code class="font-bold text-sm cursor-pointer" @click="copyToClipboard">{{ shortcode }}</code>
                <transition>
                    <div v-if="copiedFlag"
                         style="right: 110%; top: 0;"
                    class="absolute px-2 py-1 border border-red-500 bg-red-500 rounded text-white inline-block text-red-500 text-xs font-bold mt-1 text-center uppercase items-center pointer-events-none"
                    >
                        Copied!
                    </div>
                </transition>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import { FormField, HandlesValidationErrors } from 'laravel-nova'

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
        setInitialValue() {
            this.value = this.field.value || ''
        },
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
