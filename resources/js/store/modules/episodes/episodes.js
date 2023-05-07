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
                var data = new FormData();
                if (item.name){data.append('name',item.name)}
                if (item.subtitle){data.append('subtitle',item.subtitle)}
                if (item.price){data.append('price',item.price)}
                if (item.sale){data.append('sale',item.sale)}
                if (item.description){data.append('description',item.description)}
                if (item.image){data.append('image',item.image,item.image.name)}
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
