import "../../../bootstrap";

export default {

    state : {},
    mutations: {},
    actions:{
        PacksIndex(){
            return new Promise((resolve,reject) => {
                axios.get('packs').then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        PacksStore(_,item){
            return new Promise((resolve,reject) => {
                axios.post('packs',item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        PacksEdit(_,item){
            return new Promise((resolve,reject) => {
                axios.post('packs/'+item.id,item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        PacksDelete(_,item){
            return new Promise((resolve,reject) => {
                axios.delete('packs/'+item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

    }

}
