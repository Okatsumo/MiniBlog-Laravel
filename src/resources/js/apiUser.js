class ApiUser{
    constructor(userId) {
        this.id = userId;
        this.name = null;
        this.email = null;
        this.emailVerifiedAt = null;
        this.avatar = null;

        axios('/api/get-user/' + this.id)
            .then(res=>{
                this.name = res.data.user.name;
                this.email = res.data.user.email;
                this.emailVerifiedAt = res.data.user.email_verified_at;
                this.avatar = res.data.user.avatar;
                this.description = res.data.user.dec;
                this.admin = res.data.user.admin;
                this.banned = res.data.user.banned;
                this.createdAt = res.data.user.created_at;
                this.updatedAt = res.data.user.updated_at;
            })
            .catch(res=>{
                throw new this.exception("userId is not defined");
            })
    }

    exception(message) {
        this.message = message;
        this.name = "api.user.error";
    }


    update(){
        let data = {
            name: this.name,
            email: this.email,
            email_verified_at: this.emailVerifiedAt,
            avatar: this.avatar,
            dec: this.description,
            admin: this.admin,
            banned: this.banned,
            created_at: this.createdAt,
            updated_at: this.updatedAt,
        }

        axios.get('/api/user/1/edit', {
            params: data
        })
            .then(res=>{
                console.log(res)
            })
            .catch(({res}) => {
                console.log(res)
            if (res.status === 401) {

            }
        })
    }


}

export default ApiUser;
