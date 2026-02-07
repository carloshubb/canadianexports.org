import { ref, computed } from "vue";
import en from "@/lang/en.json";
import es from "@/lang/es.json";

const messages = { en, es };
const supportedLocales = ["en", "es"];

function getInitialLocale() {
  if (typeof window === "undefined") return "en";
  if (window.__LOCALE__ && supportedLocales.includes(window.__LOCALE__)) {
    return window.__LOCALE__;
  }
  const path = window.location.pathname;
  const segment = path.split("/").filter(Boolean)[0] || "";
  const lower = segment.toLowerCase();
  if (supportedLocales.includes(lower)) return lower;
  return "en";
}

const currentLocale = ref(getInitialLocale());

function setLocale(locale) {
  if (supportedLocales.includes(locale)) {
    currentLocale.value = locale;
  }
}

function translate(key) {
  const locale = currentLocale.value;
  const dict = messages[locale];
  if (!dict) return key;
  const value = dict[key];
  if (value !== undefined && value !== null) return value;
  return messages.en && messages.en[key] !== undefined ? messages.en[key] : key;
}

/**
 * Use in Vue components (Composition API or Options API setup).
 * @returns {{ __: (key: string) => string, locale: import('vue').Ref<string>, setLocale: (locale: string) => void }}
 */
export function useTranslation() {
  const __ = (key) => translate(key);
  return {
    __,
    locale: currentLocale,
    setLocale,
  };
}

export { currentLocale, setLocale, messages, supportedLocales, translate };
