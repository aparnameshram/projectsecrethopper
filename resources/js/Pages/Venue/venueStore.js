import { reactive } from "vue";
export const venueStore = reactive({
    count: 0,

    openEditVenueModal(venue) {
        alert(venue)
    }
})
