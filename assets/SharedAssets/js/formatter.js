let moment;

try {
    moment = require('moment');
} catch (error) {
    console.warn('La librería moment.js no está instalada.');
    moment = null;
}

class Formatter {
    formatField(value, returnText = '-', property = 'name') {
        return !["", null, undefined].includes(value)
            ? (typeof value === "object" && Object.keys(value).length > 0
                ? (!["", null, undefined].includes(value[property]) ?
                    value[property]
                    : returnText)
                : value)
            : returnText;
    }

    formatArray(array, concatChar = ', ', returnText = '-') {
        return !["", null, undefined].includes(array) && Array.isArray(array) && array.length > 0 ? array.map(item => this.formatField(item)).join(concatChar) : returnText;
    }

    trimArray(array, slice = 1, concatChar = ', ', returnText = '-', property = 'name') {
        if (!["", null, undefined].includes(array) && Array.isArray(array) && array.length > 0) {
            let formatedArray = array.map(item => this.formatField(item, returnText, property));
            if (formatedArray.length > slice) {
                let initValue = formatedArray.slice(0, slice).join(concatChar);
                let alt = formatedArray.join(concatChar);
                return `${initValue}...<a href="javascript:void(0)" title="${alt}"><i class="flaticon-info"></i></a>`;
            }
            return formatedArray.join(concatChar);
        }
        return returnText;
    }

    /**
     * FIXME de momento no se permite la personalización de traducciones de retorno. Usar los resultados con txtTrans.xxx[{valor devuelto}]
     */
    formatBoolean(value, returnText = '-') {
        return typeof value === "boolean" ? (value ? 'yes' : 'no') : returnText;
    }

    formatFloat(value, fixed = 2, returnText = '-') {
        return !["", null, undefined].includes(value) && !isNaN(Number.parseFloat(value)) ? this.formatField(Number.parseFloat(value).toFixed(fixed)) : returnText;
    }

    /**
     * FIXME usando formateo con Intl, al hacer new Date() sólo acepta cadenas de fechas con formato yyyy-mm-dd.
     * TODO probar a obtener formato creando un Date mediante el timestamp
    */
    formatDate(date, locale = "es", returnText = '-') {
        return !["", null, undefined].includes(date) ?
            (moment ? moment(date, "DD/MM/YYYY").format("DD/MM/YYYY") : new Intl.DateTimeFormat(locale, { year: 'numeric', month: '2-digit', day: '2-digit' }).format(new Date(date)))
            : returnText;
    }
    /**
     * FIXME usando formateo con Intl, al hacer new Date() sólo acepta cadenas de fechas con formato yyyy-mm-dd.
     * TODO probar a obtener formato creando un Date mediante el timestamp
    */
    formatDateTime(date, locale = "es", returnText = '-') {
        return !["", null, undefined].includes(date) ?
            (moment ? moment(date, "DD/MM/YYYY HH:mm:ss").format("DD/MM/YYYY HH:mm:ss") : new Intl.DateTimeFormat(locale, { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', second: '2-digit' }).format(new Date(date.replace(" ", "T"))))
            : returnText;
    }

    convertDateToDateTime(date, locale = "es", returnText = '-') {
        let formattedDate = returnText;

        formattedDate = !["", null, undefined].includes(date) ?
            (moment ? moment(date, "DD/MM/YYYY") : (date instanceof Date ? date : new Date(date)))
            : returnText;

        if (moment && moment.isMoment(formattedDate)) {
            formattedDate = formattedDate.set({
                hour: moment().hour(),
                minute: moment().minute(),
                second: moment().second()
            });
            formattedDate = formattedDate.format("DD/MM/YYYY HH:mm:ss");
        } else if (formattedDate instanceof Date) {
            formattedDate.setHours(new Date().getHours());
            formattedDate.setMinutes(new Date().getMinutes());
            formattedDate.setSeconds(new Date().getSeconds());
            formattedDate = new Intl.DateTimeFormat(locale, {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }).format(formattedDate);
        }

        return formattedDate;
    }

    /**
     * TODO de momento no se permite la personalización del separador
     */
    concatFields(...fields) {
        return fields.map(item => this.formatField(item)).join(' / ');
    }
}

export default new Formatter;