import "../../../bootstrap";

export default {

    state : {},
    mutations: {},
    actions:{
        ConfigsIndex(){
            return new Promise((resolve,reject) => {
                axios.get('configs').then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

        ConfigsEdit(_,item){
            return new Promise((resolve,reject) => {
                axios.post('configs/'+item.id,item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        ConfigsSetDefault(){
            return new Promise((resolve,reject) => {
                axios.get('configs/set/default').then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

    }

}
