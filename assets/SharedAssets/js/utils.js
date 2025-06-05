export function getUser() {
    let name = 'auth.user';
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");
        if (name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }
}

/**
 * 
 * @param {*} string 
 * @param {*} lowerRest si se desea poner en minusculas el resto de la cadena. Activo por defecto
 * @returns capitalized string
 */
export function capitalize(string, lowerRest = true, allWords = false) {
    if (allWords && string.includes(' ')) {
        return string.split(' ').map(word => capitalize(word, lowerRest)).join(' ');
    }
    return string.charAt(0).toUpperCase() + (lowerRest ? string.slice(1).toLowerCase() : string.slice(1));
}

/**
 * 
 * @param {*} document context
 * @param {*} file blob file
 * @param {*} fileName name of the file
 */
export function downloadBlobFileButtonAction(document, file, fileName) {
    let link = document.createElement("a");
    link.href = URL.createObjectURL(file);
    link.target = "_blank";
    link.download = fileName;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

export function isValidURL(url) {
    try {
        new URL(url);
        return true;
    } catch (e) {
        return false;
    }
}