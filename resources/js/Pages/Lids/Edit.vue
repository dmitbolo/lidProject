<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Inertia} from "@inertiajs/inertia";

// Преобразуем массив статусов в объект для удобного доступа
const props = defineProps(['lid']);

const form = useForm({
    id: props.lid.id,
    first_name: props.lid.first_name,
    last_name: props.lid.last_name,
    phone: props.lid.phone,
    email: props.lid.email,
    text: props.lid.text,
});

// const id = props.lid.id;

</script>

<template>

    <Head title="Редактирование лида" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Редактирование лида</h2>
        </template>
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="Inertia.patch('/lid/update/' + id, form)" class="mt-6 space-y-6">
                        <div>
                            <InputLabel for="first_name" value="Имя" />

                            <TextInput
                                id="first_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.first_name"
                                required
                                autofocus
                                autocomplete="first_name"
                            />

                            <InputError class="mt-2" :message="form.errors.first_name"/>
                        </div>

                        <div>
                            <InputLabel for="last_name" value="Фамилия"/>

                            <TextInput
                                id="last_name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.last_name"
                                required
                                autofocus
                                autocomplete="last_name"
                            />

                            <InputError class="mt-2" :message="form.errors.last_name"/>
                        </div>

                        <div>
                            <InputLabel for="phone" value="Номер телефона"/>

                            <TextInput
                                id="phone"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.phone"
                                required
                                autofocus
                                autocomplete="phone"
                            />

                            <InputError class="mt-2" :message="form.errors.phone"/>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full"
                                v-model="form.email"
                                required
                                autocomplete="username"
                            />
                            <!--                                @input="checkForm"-->

                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>

                        <div>
                            <InputLabel for="text" value="Текст обращения" />

                            <TextInput
                                id="text"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.text"
                                required
                                autocomplete="text"
                            />

                            <InputError class="mt-2" :message="form.errors.text"/>
                        </div>

                        <PrimaryButton type="submit">Редактировать лида</PrimaryButton>
                        <!--                        <PrimaryButton type="submit" :disabled="!isFormValid">Создать лид</PrimaryButton>-->
                    </form>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>

</template>

<style>

</style>
