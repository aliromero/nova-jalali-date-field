<template>
  <DefaultField
    :field="currentField"
    :errors="errors"
    :show-help-text="showHelpText"
    :full-width-content="fullWidthContent"
  >
    <template #field>
      <div class="flex">
        <date-picker
          :class="errorClasses"
          :clearable="true"
          :color="color"
          :format="format"
          :id="currentField.uniqueKey"
          :initial-value="fieldValue"
          :input-attrs="{ style: 'direction: ltr; text-align: end;' }"
          inputClass="w-full form-control form-input form-input-bordered"
          :locale="locale"
          :max="maxDate"
          :min="minDate"
          :placeholder="placeholder"
          type="date"
          v-model="value"
        >
          <template #clear-btn="{ vm }">
            <svg
              role="img"
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 352 512"
              class="ml-2"
              style="height: 16px; margin-top: 11px"
            >
              <path
                fill="currentColor"
                d="M242.72 256l100.07-100.07c12.28-12.28 12.28-32.19 0-44.48l-22.24-22.24c-12.28-12.28-32.19-12.28-44.48 0L176 189.28 75.93 89.21c-12.28-12.28-32.19-12.28-44.48 0L9.21 111.45c-12.28 12.28-12.28 32.19 0 44.48L109.28 256 9.21 356.07c-12.28 12.28-12.28 32.19 0 44.48l22.24 22.24c12.28 12.28 32.2 12.28 44.48 0L176 322.72l100.07 100.07c12.28 12.28 32.2 12.28 44.48 0l22.24-22.24c12.28-12.28 12.28-32.19 0-44.48L242.72 256z"
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
// import { DependentFormField, HandlesValidationErrors } from "laravel-nova";
import jMoment from "moment-jalaali";

export default {
  components: {
    DatePicker: Vue3PersianDatetimePicker,
  },

  //   mixins: [DependentFormField, HandlesValidationErrors],

  props: ["resourceName", "resourceId", "field"],

  computed: {
    altDateValue() {
      return this.value
        ? jMoment(this.value, this.format).format("YYYY-MM-DD")
        : "";
    },

    color() {
      return this.currentField.color || "rgb(30, 136, 229)";
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
      return this.currentField.value
        ? jMoment(this.currentField.value).format(this.format)
        : "";
    },

    format() {
      return this.currentField.format || "jYYYY/jMM/jDD";
    },

    locale() {
      return this.currentField.locale || "fa,en";
    },

    placeholder() {
      return this.currentField.placeholder || jMoment().format(this.format);
    },
  },

  methods: {
    fill(formData) {
      this.fillIfVisible(
        formData,
        this.field.attribute,
        this.altDateValue || ""
      );
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
