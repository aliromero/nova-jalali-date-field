<template>
    <DefaultField
        :errors="errors"
        :field="currentField"
        :full-width-content="fullWidthContent"
        :show-help-text="showHelpText"
    >
        <template #field>
            <div class="flex">
                <date-picker
                    :id="currentField.uniqueKey"
                    v-model="value"
                    :class="errorClasses"
                    :clearable="true"
                    :color="color"
                    :format="format"
                    :initial-value="fieldValue"
                    :input-attrs="{ style: 'direction: ltr; text-align: end;' }"
                    :locale="locale"
                    :placeholder="placeholder"
                    compact-time
                    inputClass="w-full form-control form-input form-input-bordered"
                    :max="maxDate"
                    :min="minDate"
                    type="datetime"
                >
                    <template #clear-btn="{ vm }">
                        <svg
                            class="ml-2"
                            role="img"
                            style="height: 16px; margin-top: 11px"
                            viewBox="0 0 352 512"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
                                fill="currentColor"
                            ></path>
                        </svg>
                    </template>
                </date-picker>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import Vue3PersianDatetimePicker from "vue3-persian-datetime-picker";
import {FormField, HandlesValidationErrors} from "laravel-nova";
import jMoment from "moment-jalaali";

export default {
    components: {
        DatePicker: Vue3PersianDatetimePicker,
    },

    mixins: [FormField, HandlesValidationErrors],

    computed: {
        altDateValue() {
            return this.value
                ? jMoment(this.value, this.format).format("YYYY-MM-DD HH:mm:ss")
                : "";
        },

        color() {
            return this.field.color || "rgb(30, 136, 229)";
        },
        minDate() {
            if (!this.field.min) return "";
            var minDate = this.calculateMoment(this.field.min, "min");
            return minDate.format("jYYYY/jM/jD");
        },
        maxDate() {
            if (!this.field.max) return "";
            var maxDate = this.calculateMoment(this.field.max, "max");
            return maxDate.format("jYYYY/jM/jD");
        },


        fieldValue() {
            return this.field.value
                ? jMoment(this.field.value).format(this.format)
                : "";
        },

        format() {
            return this.field.format || "jYYYY/jMM/jDD HH:mm";
        },

        locale() {
            return this.field.locale || "fa,en";
        },

        placeholder() {
            return this.field.placeholder || jMoment().format(this.format);
        },
    },

    methods: {
        fill(formData) {
            formData.append(this.field.attribute, this.value || '')
        },
        calculateMoment(value, type) {
            var m = new jMoment();
            if (value == "lastyear") {
                m.jYear(m.jYear() - 1);
            } else if (value == "lastmonth") {
                m.jMonth(m.jMonth() - 1);
            } else if (value == "lastweek") {
                m.jDate(m.jDate() - 7);
            } else if (value == "lastday") {
                m.jDate(m.jDate() - 1);
            } else if (value == "today") {
                if (type == "max") {
                    m.endOf("day");
                } else {
                    m.startOf("day");
                }
            } else if (value == "thisyear") {
                if (type == "max") {
                    m.endOf("jyear");
                } else {
                    m.startOf("jyear");
                }
            } else if (value == "thismonth") {
                if (type == "max") {
                    m.endOf("jmonth");
                } else {
                    m.startOf("jmonth");
                }
            } else if (value == "thisweek") {
                if (type == "max") {
                    m.endOf("jweek");
                } else {
                    m.startOf("jweek");
                }
            } else if (value == "nextyear") {
                m.jYear(m.jYear() + 1);
            } else if (value == "nextmonth") {
                m.jMonth(m.jMonth() + 1);
            } else if (value == "nextweek") {
                m.jDate(m.jDate() + 7);
            } else if (value == "nextday") {
                m.jDate(m.jDate() + 1);
            } else if (
                value.indexOf("/") !== -1 &&
                jMoment(value, "jYYYY/jMM/jDD").isValid()
            ) {
                m = jMoment(value, "jYYYY/jMM/jDD");
            } else if (
                value.indexOf("-") !== -1 &&
                jMoment(value, "jYYYY-jMM-jDD").isValid()
            ) {
                m = jMoment(value, "jYYYY-jMM-jDD");
            } else if (
                value.indexOf("/") !== -1 &&
                jMoment(value, "YYYY/MM/DD", true).isValid()
            ) {
                m = jMoment(value, "YYYY/MM/DD");
            } else if (
                value.indexOf("-") !== -1 &&
                jMoment(value, "YYYY-MM-DD", true).isValid()
            ) {
                m = jMoment(value, "YYYY-MM-DD");
            } else {
                m = jMoment(value, "jYYYY-jMM-jDD");
            }
            return m;
        },


        setInitialValue() {
            this.value = this.fieldValue;
        },
    },
};
</script>
