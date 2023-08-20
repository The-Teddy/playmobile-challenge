import axios from "axios";

const api = process.env.REACT_APP_API_URL + "/api";

export function getNews() {
  return axios.get(`${api}/news`);
}

export function getNewsDetail(id) {
  return axios.get(`${api}/news/detail/?id=${id}`);
}
