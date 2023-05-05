import "../../../bootstrap";

export default {

    state : {},
    mutations: {},
    actions:{
        EpisodesIndex(){
            return new Promise((resolve,reject) => {
                axios.get('episodes').then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        EpisodesStore(_,item){
            return new Promise((resolve,reject) => {
                axios.post('episodes',item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        EpisodesEdit(_,item){
            return new Promise((resolve,reject) => {
                axios.post('episodes/'+item.id,item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        EpisodesDelete(_,item){
            return new Promise((resolve,reject) => {
                axios.delete('episodes/'+item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        EpisodesChangeStatus(_,item){
            return new Promise((resolve,reject) => {
                axios.get('episodes/activation/'+item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

    }

}
