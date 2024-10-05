const TokenService = {
    tokenName: 'token',
    getToken() {
        return window.localStorage.getItem(this.tokenName);
    },
    saveToken(token) {
        window.localStorage.setItem(this.tokenName, token);
    },
    destroyToken() {
        window.localStorage.removeItem(this.tokenName);
    }
}

export default TokenService;
