<?php

namespace MZiraki\PersianDateField;

trait HasOptions
{
    /**
     * Set datePicker Color. See https://talkhabi.github.io/vue-persian-datetime-picker/guide/theme.
     *
     * @param $color
     *
     * @return $this
     */
    public function color($color)
    {
        return $this->withMeta(compact('color'));
    }

    /**
     * format based on jalali-moment. See https://github.com/jalaali/moment-jalaali.
     *
     * @param string $format
     *
     * @return $this
     */
    public function format($format)
    {
        return $this->withMeta(compact('format'));
    }

    /**
     * Set datePicker Locale. See https://talkhabi.github.io/vue-persian-datetime-picker/guide/localization.
     *
     * @param $locale
     *
     * @return $this
     */
    public function locale($locale)
    {
        return $this->withMeta(compact('locale'));
    }


    /**
     * Set Minimum Date.
     *
     * @param string :TODO: add more formats (timestamp, carbon, jdate, string)
     * @return PersianDateTime
     */
    public function min($min)
    {
        return $this->withMeta(compact('min'));
    }

    /**
     * Set Maximum Date.
     *
     * @param string :TODO: add more formats (timestamp, carbon, jdate, string)
     * @return PersianDateTime
     */
    public function max($max)
    {
        return $this->withMeta(compact('max'));
    }
}
