import { ref } from 'vue'
import { defineStore } from 'pinia'
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc'
import customParseFormat from 'dayjs/plugin/customParseFormat'
dayjs.extend(utc);
dayjs.extend(customParseFormat);

export const useGroupStore = defineStore('group', {
    state: () => ({
        timeslots: [],
        users: [],
        existingUsers: []
    }),
    getters: {
        allTimeslots(state) {
            return state.timeslots
        },


    },
    actions: {
        insertTimeslot(timeslot) {
            this.timeslots.push(timeslot)
        },
        removeTimeslot(index) {
            this.timeslots.splice(index, 1)
        },
        getTimeslot(index) {
            return this.timeslots[index]
        },
        updateTimeslot(timeslot, index) {
            this.timeslots[index] = timeslot
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
        },
        getTimeslotFormatedDateTime(timeslot) {
            let tDate = dayjs(new Date(timeslot.date)).format('YYYY-MM-DD')
            let startStr = tDate + ' ' + timeslot.start_time
            let endStr = tDate + ' ' + timeslot.end_time
            let sTime = dayjs(startStr)
            let eTime = dayjs(endStr)
            return { date: tDate, start_time: sTime, end_time: eTime }
        }

    },
})
