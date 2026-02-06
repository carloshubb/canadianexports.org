import swal from "sweetalert2";

if (!document.getElementById('swal-custom-styles')) {
    const style = document.createElement('style');
    style.id = 'swal-custom-styles';
    style.textContent = `
        .swal2-container .swal2-popup.gradient-border-modal {
            border: 3px solid transparent !important;
            border-radius: 0.75rem !important;
            background: 
                linear-gradient(white, white) padding-box,
                linear-gradient(120deg, #0077ff, #00ffff, #ff00ff, #ff8800) border-box !important;
            outline: none !important;
            box-shadow: none !important;
        }
    `;
    document.head.appendChild(style);
}
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
                popup: "gradient-border-modal",
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
                popup: "gradient-border-modal",
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
            background: "#ffffffff",
            buttonsStyling: false,
            customClass: {
                popup: "gradient-border-modal", // Add custom class for the popup container
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            html: `<p class="text-center">${message}</p>`,
        });


    },
    swalSponsorSuccessForWeb(profileUrl) {
        return swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showDenyButton: !!profileUrl,
            denyButtonText: 'View My Live Profile',
            showCloseButton: true,
            background: "#ffffffff",
            buttonsStyling: false,
            customClass: {
                popup: "gradient-border-modal",
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                actions: "swal-sponsor-success-actions",
                confirmButton: 'button-exp-fill focus:outline-none',
                denyButton: 'button-exp-fill focus:outline-none',
            },
            html: `
                <div class="text-center">
                    <div class="checkmark">✓</div>
                    <h2 class="success-title">Welcome to Canadian Exports!</h2>
                    <p class="success-subtitle">You are now an Official Sponsor</p>
                    <p>Thank you for your <strong>generous support</strong>. Your <strong>partnership</strong> is already making a difference for small businesses and entrepreneurs across the nation.</p>
                    <p>Your profile is now <strong>LIVE</strong>. You can visit the <strong>Homepage</strong> to see your brand in its new featured position. A payment receipt has been sent to your email.</p>
                </div>
            `,
        }).then((result) => {
            if (result.isDenied && profileUrl) {
                window.location.href = profileUrl;
            }
            return result;
        });
    },
    swalPreSuccessMessageForWeb(message) {
        swal.fire({
            position: "center",
            showConfirmButton: true,
            confirmButtonText: 'Close',
            showCloseButton: false,
            background: "#ffffffff",
            buttonsStyling: false,
            customClass: {
                popup: "gradient-border-modal", // Add custom class for the popup container
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
            background: "#ffffffff",
            buttonsStyling: false,
            customClass: {
                popup: "gradient-border-modal", // Add custom class for the popup container
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
                popup: "gradient-border-modal", // Add custom class for the popup container
                title: "swalSuccessClass",
                htmlContainer: "swalSuccessClass",
                confirmButton: 'button-exp-fill focus:outline-none',
            },
            html: '<pre class="font-Nunito w-full whitespace-break-spaces">' + message + '</pre>',
        });
    },
};

export default helpers;
