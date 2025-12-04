import swal from "sweetalert2";
const helpers = {
    cutText(text, length) {
        if (text.split(" ").length > 1) {
            let string = text.substring(0, length);
            let splitText = string.split(" ");
            splitText.pop();
            return splitText.join(" ") + "...";
        } else {
            return text;
        }
    },
    formatDate(date, format) {
        return date;
    },
    capitalizeFirstLetter(string) {
        if (string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
    },
    onlyNumber(number) {
        if (number) {
            return number.replace(/\D/g, "");
        } else {
            return "";
        }
    },
    formatCurrency(number) {
        if (number) {
            let formattedNumber = number.toString().replace(/\D/g, "");
            let rest = formattedNumber.length % 3;
            let currency = formattedNumber.substr(0, rest);
            let thousand = formattedNumber.substr(rest).match(/\d{3}/g);
            let separator;

            if (thousand) {
                separator = rest ? "." : "";
                currency += separator + thousand.join(".");
            }

            return currency;
        } else {
            return "";
        }
    },
    isset(obj) {
        return Object.keys(obj).length;
    },
    assign(obj) {
        return JSON.parse(JSON.stringify(obj));
    },
    delay(time) {
        return new Promise((resolve, reject) => {
            setTimeout(() => {
                resolve();
            }, time);
        });
    },
    randomNumbers(from, to, length) {
        let numbers = [0];
        for (let i = 1; i < length; i++) {
            numbers.push(Math.ceil(Math.random() * (from - to) + to));
        }

        return numbers;
    },
    replaceAll(str, find, replace) {
        return str.replace(new RegExp(find, "g"), replace);
    },
    swalSuccessMessage(message) {
        swal.fire({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 3000,
            icon: "success",
            background: "rgb(220 252 231)",
            title: "Success",
            timerProgressBar: true,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
            },
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", swal.stopTimer);
                toast.addEventListener("mouseleave", swal.resumeTimer);
            },

            text: message,
        });
    },
    swalErrorMessage(message) {
        swal.fire({
            toast: true,
            position: "bottom-end",
            showConfirmButton: false,
            timer: 3000,
            icon: "error",
            background: "rgb(254 202 202)",
            title: "Error",
            timerProgressBar: true,
            customClass: {
                title: "swalErrorClass",
                htmlContainer: "swalErrorClass",
            },
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", swal.stopTimer);
                toast.addEventListener("mouseleave", swal.resumeTimer);
            },
            text: message,
        });
    },
    updateUrlParameter(p, v, s) {
        const params = new URLSearchParams(p);
        params.delete(v);
        params.append(v, s);
        return params.toString();
    },
    generateUUID() {
        var d = new Date().getTime();
        var d2 =
            (typeof performance !== "undefined" &&
                performance.now &&
                performance.now() * 1000) ||
            0; //Time in microseconds since page-load or 0 if unsupported
        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(
            /[xy]/g,
            function (c) {
                var r = Math.random() * 16; //random number between 0 and 16
                if (d > 0) {
                    //Use timestamp until depleted
                    r = (d + r) % 16 | 0;
                    d = Math.floor(d / 16);
                } else {
                    //Use microseconds since page-load if supported
                    r = (d2 + r) % 16 | 0;
                    d2 = Math.floor(d2 / 16);
                }
                return (c === "x" ? r : (r & 0x3) | 0x8).toString(16);
            }
        );
    },
    swalSuccessMessageForWeb(message) {
        return swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showCloseButton: false,
            background: "#fff",
            buttonsStyling: false,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            html: `<p class="text-center">${message}</p>`,
        });
    },
    swalPreSuccessMessageForWeb(message) {
        swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showCloseButton: false,
            background: "#fff",
            buttonsStyling: false,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            html: `<pre class="font-Nunito">${message}</pre>`,
        });
    },
    swalErrorMessageForWeb(message) {
        swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showCloseButton: false,
            background: "#fff",
            buttonsStyling: false,
            customClass: {
                title: "swalErrorClass",
                htmlContainer: "swalErrorClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            text: message,
        });
    },
    swalPreSuccessMessageForWeb(message) {
        swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showCloseButton: false,
            background: "#fff",
            buttonsStyling: false,
            customClass: {
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            html: '<pre class="font-Nunito w-full whitespace-break-spaces">' + message + '</pre>',
        });
    },
};

export default helpers;
