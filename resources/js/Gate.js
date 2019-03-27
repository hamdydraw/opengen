export default class Gate{

    constructor(user)
    {
        this.user=user;
    }
    isAdmin(){
        return this.user.type==='admin';
    }
    isVendor(){
        return this.user.type==='vendor';
    }
    
    isAdminOrVendor(){ 
        if(this.user.type==='vendor' || this.user.type==='admin'){ 
        return true;
        }
    }
}