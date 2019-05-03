export default class Gate{

    constructor(user)
    {
        this.user=user;
    }
    isAdmin(){
        
        return this.user.type==='admin';
    }
    isMerchant(){
        return this.user.type==='merchant';
    }
    isEU(){
        return this.user.type==='enduser';
    }
    isPilot(){
        return this.user.type==='pilot';
    }
    isDMM(){
        return this.user.type==='dmm';
    }
    isAdminOrMerchant(){ 
        if(this.user.type==='merchant' || this.user.type==='admin'){ 
        return true;
        }
    }
}