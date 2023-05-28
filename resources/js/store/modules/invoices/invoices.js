import "../../../bootstrap";

export default {

    state : {},
    mutations: {},
    actions:{
        InvoicesIndex(){
            return new Promise((resolve,reject) => {
                axios.get('invoices').then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },
        InvoicesChangePay(_,item){
            return new Promise((resolve,reject) => {
                axios.get('invoices/change/payment/'+item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

        InvoicesStore(_,item){
            return new Promise((resolve,reject) => {
                axios.post('faqs',item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

        InvoicesEdit(_,item){
            return new Promise((resolve,reject) => {
                axios.post('faqs/'+item.id,item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

        InvoicesDelete(_,item){
            return new Promise((resolve,reject) => {
                axios.delete('faqs/'+item).then((result) => {
                    resolve(result);
                }).catch(error => {
                    reject(error);
                })
            } )
        },

    }

}
