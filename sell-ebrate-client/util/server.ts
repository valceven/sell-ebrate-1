export const serverDomain = "http://localhost:5000/";

export function urlParamsSerializer(params: Object) {
  return Object.entries(params)
    .map(
      ([key, value]) =>
        `${key}=${value instanceof Date ? value.toLocaleString() : value}`,
    )
    .join("&");
}
