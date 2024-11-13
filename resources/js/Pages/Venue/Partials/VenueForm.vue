<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';

import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import TextareaInput from '@/Components/TextareaInput.vue';
import { computed } from 'vue';
import SelectInput from '@/Components/SelectInput.vue';
import { usePage } from '@inertiajs/vue3'
import TimezoneList from '@/Components/TimezoneList.vue';
import { defineEmits } from 'vue';
import ModalFormContainer from '@/Components/ModalFormContainer.vue';
import ModalFormField from '@/Components/ModalFormField.vue';

const selectOptions = computed(() => usePage().props.selectOptions)
const questionairLink =  usePage().props.questionnaire.link
const uniqueInstructions = usePage().props.questionnaire.unique_instructions

const props = defineProps({
    venue: {
        type:Object,
        default(rawProps) {
            return {
                id : null,
                name : '',
                radius : '2',
                latitude : '',
                longitude : '',
                address : '',
                city : '',
                state : '',
                country : '',
                zip : '',
                timezone : '',
                questionnaire_link : null,
                unique_instructions : null,
                status : 'active',
            }
        }
    }
})

const emit = defineEmits(['close'])


const form = useForm({
    id:props.venue.id,
    name: props.venue.name,
    address: props.venue.address,
    city:  props.venue.city,
    state:  props.venue.state,
    zip:  props.venue.zip,
    timezone:  props.venue.timezone,
    radius:  props.venue.radius.toString(),
    country:  props.venue.country,
    status:  props.venue.status,
    questionnaire_link: (props.venue.questionnaire_link != null) ? props.venue.questionnaire_link : questionairLink,
    unique_instructions:  (props.venue.unique_instructions != null) ? props.venue.unique_instructions : uniqueInstructions,
});

const submit = () => {
    if (props.venue.id !== null)  {
        form.patch(route('venue.update', props.venue.id), {
            onSuccess: () => {
            emit('close')
                form.reset()
            },
        });
    } else {
        form.post(route('venue.save'),{
            onSuccess:() => {
                emit('close')
                form.reset()
            }
        })
    }
}
</script>
<template>
    <form @submit.prevent="submit">
        <ModalFormContainer>
            <template #title>Update Venue</template>
            <ModalFormField>
                <template #label>
                    <InputLabel for="name" value="Name" />
                </template>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </ModalFormField>
            <ModalFormField>
                <template #label>
                    <InputLabel for="address" value="Address" />
                </template>
                <TextInput
                    id="address"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                    required
                    autofocus
                    autocomplete="address"
                />
                <InputError class="mt-2" :message="form.errors.address" />
            </ModalFormField>
            <ModalFormField>
                <template #label>
                    <InputLabel for="city" value="City" />
                </template>
                <TextInput
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                    required
                    autofocus
                    autocomplete="city"
                />
                <InputError class="mt-2" :message="form.errors.city" />
            </ModalFormField>
            <ModalFormField>
                <template #label>
                <InputLabel for="state" value="state" />
                </template>
                <TextInput
                    id="state"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.state"
                    required
                    autofocus
                    autocomplete="state"
                />
                <InputError class="mt-2" :message="form.errors.state" />
            </ModalFormField>
            <ModalFormField>
                <template #label>
                <InputLabel for="zip" value="zip" />
                </template>
                <TextInput
                    id="zip"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.zip"
                    required
                    autofocus
                    autocomplete="zip"
                />
                <InputError class="mt-2" :message="form.errors.zip" />
            </ModalFormField>
            <ModalFormField >
                <template #label>
                <InputLabel for="country" value="country" />
                </template>
                <TextInput
                    id="country"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.country"
                    required
                    autofocus
                    autocomplete="country"
                />
                <InputError class="mt-2" :message="form.errors.country" />
            </ModalFormField>
            <ModalFormField >
                <template #label>
                    <InputLabel for="radius" value="radius" />
                </template>
                <TextInput
                    id="radius"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.radius"
                    required
                    autofocus
                    autocomplete="radius"
                />
                <InputError class="mt-2" :message="form.errors.radius" />
            </ModalFormField>
            <ModalFormField >
                <template #label>
                    <InputLabel for="timezone" value="Timezone" />
                </template>
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
            </ModalFormField>
            <ModalFormField>
                <template #label>
                <InputLabel for="status" value="status" />
                </template>
                <SelectInput
                    id="status"

                    class="mt-1 block w-full"
                    v-model="form.status"
                    required
                    autofocus
                    autocomplete="status"
                    :options="selectOptions.status"
                />
                <InputError class="mt-2" :message="form.errors.status" />
            </ModalFormField>
            <ModalFormField >
                <template #label>
                <InputLabel for="questionnaire_link" value="questionnaire link" />
                </template>
                <TextInput
                    id="questionnaire_link"
                    type="text"
                    class="mt-1 p-2 block w-full"
                    v-model="form.questionnaire_link"
                    required
                    autofocus
                    autocomplete="questionnaire_link"

                />
                <InputError class="mt-2" :message="form.errors.questionnaire_link" />
            </ModalFormField>
            <ModalFormField>
                <template #label>
                    <InputLabel for="unique_instructions" value="Unique Instructions" />
                </template>
                <TextareaInput
                    id="unique_instructions"
                    class="mt-1 p-2 block w-full"
                    v-model="form.unique_instructions"
                    required
                    autofocus
                    autocomplete="unique_instructions"
                />
                <InputError class="mt-2" :message="form.errors.unique_instructions" />
            </ModalFormField>
            <ModalFormField>
                <div class="flex justify-center">
                    <PrimaryButton
                        @click.prevent="submit"
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
                    </PrimaryButton>
                    <PrimaryButton
                        @click="$emit('close')"
                        class="ms-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Cancel
                    </PrimaryButton>
                </div>
            </ModalFormField>
        </ModalFormContainer>
    </form>
</template>
