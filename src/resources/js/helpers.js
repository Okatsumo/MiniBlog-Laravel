import axios from "axios";

window.getCookie = function(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

window.setRefreshToken = function() {
    let accessToken = getCookie("access");
    axios.put(`/api/auth/refreshToken?accessToken=`+accessToken).then(res=>{
        document.cookie = `refresh = ${res.data.refreshToken}`;
        return true;
    })
    .catch(error=>{
        return false;
    })
}
