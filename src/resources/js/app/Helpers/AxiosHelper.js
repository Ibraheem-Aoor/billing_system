const baseURl = window.localStorage.getItem('base_url') || window.location.origin;
import AxiosFunction from "../../core/helpers/axios/AxiosFunction";
import axios from 'axios';

export const urlGenerator = (url) => {
    return `${baseURl}/${url.split('/').filter(d => d).join('/')}`;
};

export const axiosGet = (url) => {
    return AxiosFunction.axiosGet(urlGenerator(url));
};


export const axiosPost = (url, data) => {
    return AxiosFunction.axiosPost({
        url: urlGenerator(url),
        data
    });
};

export const axiosPatch = (url, data) => {
    return axios.patch(urlGenerator(url), data);
};

export const axiosDelete = (url) => {
    return AxiosFunction.axiosDelete(urlGenerator(url));
};
