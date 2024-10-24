<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TimezoneList from '@/Components/TimezoneList.vue';
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SelectInput from '@/Components/SelectInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';

const open = ref(false)
const questionairLink = computed(() => usePage().props.questionnaire.link)
const uniqueInstructions = computed(() => usePage().props.questionnaire.unique_instructions)
defineProps(['venue'])
const form = useForm({
    name: '',
    address: '',
    city: '',
    state: '',
    zip: '',
    timezone: '',
    radius: '',
    country: '',
    status: 'active',
    questionnaire_link: questionairLink,
    unique_instructions: uniqueInstructions
});
const statval = ref('')

statval.value = 'editform'
const closeModel = () => {
    open.value = false
}
const openModel = () => {
    open.value = true
}
defineExpose({
    closeModel,
    openModel,
    statval
})
const submit = () => {
    form.post(route('venue.edit'), {
        onSuccess: () => {
            closeModel()
            form.reset()
        },
        onFinish: () => open.value = false,
    });
}

</script>
<template>
<TransitionRoot as="template" :show="open">
    <Dialog class="relative z-10" @close="open = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel class="relative transform  rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                    <div class="flex min-h-full  justify-center p-4 flex-col">
                        <div class="mt-5 mb-5">
                            <h3 class="text-base font-semibold leading-6 text-gray-900">Add Venue</h3>
                        </div>
                        <form @submit.prevent="submit">
                        <div class="mt-5">
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="name"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="address" value="Address" />

                            <TextInput
                                id="address"
                                type="address"
                                class="mt-1 block w-full"
                                v-model="form.address"
                                required
                                autofocus
                                autocomplete="address"
                            />

                            <InputError class="mt-2" :message="form.errors.address" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="city" value="city" />

                            <TextInput
                                id="city"
                                type="city"
                                class="mt-1 block w-full"
                                v-model="form.city"
                                required
                                autofocus
                                autocomplete="city"
                            />

                            <InputError class="mt-2" :message="form.errors.city" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="state" value="state" />

                            <TextInput
                                id="state"
                                type="state"
                                class="mt-1 block w-full"
                                v-model="form.state"
                                required
                                autofocus
                                autocomplete="state"
                            />

                            <InputError class="mt-2" :message="form.errors.state" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="zip" value="zip" />

                            <TextInput
                                id="zip"
                                type="zip"
                                class="mt-1 block w-full"
                                v-model="form.zip"
                                required
                                autofocus
                                autocomplete="zip"
                            />

                            <InputError class="mt-2" :message="form.errors.zip" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="country" value="country" />

                            <TextInput
                                id="country"
                                type="country"
                                class="mt-1 block w-full"
                                v-model="form.country"
                                required
                                autofocus
                                autocomplete="country"
                            />

                            <InputError class="mt-2" :message="form.errors.country" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="radius" value="radius" />

                            <TextInput
                                id="radius"
                                type="radius"
                                class="mt-1 block w-full"
                                v-model="form.radius"
                                required
                                autofocus
                                autocomplete="radius"
                            />

                            <InputError class="mt-2" :message="form.errors.radius" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="timezone" value="Timezone" />

                            <TimezoneList
                            id="timezone"
                            class="mt-1 block "
                            v-model="form.timezone"
                            required
                            autofocus
                            autocomplete="timezone"
                            :options="selectOptions.timezone"
                        />

                            <InputError class="mt-2" :message="form.errors.timezone" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="status" value="status" />

                            <SelectInput
                                id="status"
                                type="status"
                                class="mt-1 block w-full"
                                v-model="form.status"
                                required
                                autofocus
                                autocomplete="status"
                                :options="selectOptions.status"
                            />

                            <InputError class="mt-2" :message="form.errors.status" />
                        </div>

                        <div class="mt-5">
                            <InputLabel for="questionnaire_link" value="questionnaire_link" />

                            <TextInput
                                id="questionnaire_link"
                                type="questionnaire_link"
                                class="mt-1 block w-full"
                                v-model="form.questionnaire_link"
                                required
                                autofocus
                                autocomplete="questionnaire_link"

                            />

                            <InputError class="mt-2" :message="form.errors.questionnaire_link" />
                        </div>
                        <div class="mt-5">
                            <InputLabel for="unique_instructions" value="unique_instructions" />

                            <TextareaInput
                                id="unique_instructions"
                                type="unique_instructions"
                                class="mt-1 block w-full"
                                v-model="form.unique_instructions"
                                required
                                autofocus
                                autocomplete="unique_instructions"
                            />

                            <InputError class="mt-2" :message="form.errors.unique_instructions" />
                        </div>
                        <div class="mt-4 flex items-center justify-end">
                            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto" @click="open = false" ref="cancelButtonRef">Cancel</button>
                            <PrimaryButton
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Submit
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
