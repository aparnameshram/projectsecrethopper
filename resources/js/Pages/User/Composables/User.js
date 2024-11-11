import { ref } from "vue";
export function userModal() {
    // keep track of component to render
    const user = ref('');
    // keep track of whether to show modal
    const emptyuser = {
        id:null,
        first_name:'',
        last_name:'',
        phone:'',
        email:'',
        user_profile : {
            address : '',
            gender : '',
            timezone : '',
            date_signed : ''
        }
    };

    return {

        user,
        createEmptyUser: () => {
            user.value = emptyuser
        }
    }
}
