import { ref } from 'vue'
import { defineStore } from 'pinia'

export const useGroupStore = defineStore('group', {
    state: () => ({
        timeslots: [],
        users: [],
        existingUsers: []
    }),
    getters: {
        allTimeslots(state) {
            return state.timeslots
        }
    },
    actions: {
        insertTimeslot(timeslot) {
            this.timeslots.push(timeslot)
        },
        removeTimeslot(index) {
            this.timeslots.splice(index, 1)
        },
        insertUser(user) {
            this.users.push(user)
        },
        removeUser(index) {
            this.users.splice(index, 1)
        },
        insertAllUsers(selected) {
            this.users = selected
        },
        removeAllUsers() {
            this.users = []
        },
        insertAllTimeslots(timeslots) {
            this.timeslots = timeslots
        },
        setUpExistingUsers(users) {
            this.existingUsers = users
        }
    },
})
