<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {onMounted, ref} from 'vue';
import Li from "@/Components/Li.vue";
import axios from 'axios';
import {Inertia} from "@inertiajs/inertia";

const selected = ref('');
const props = defineProps(['lids', 'lidsCount', 'newLidCount', 'inProgressLidCount', 'completedLidCount', 'status']);

const newLidCount = ref(0);
const inProgressLidCount = ref(0);
const completedLidCount = ref(0);

const lids = ref(props.lids);
const status = ref(props.status);

newLidCount.value = props.newLidCount;
inProgressLidCount.value = props.inProgressLidCount;
completedLidCount.value = props.completedLidCount;

onMounted(() => {
    lids.value.forEach(lid => {
        lid.selectedStatusId  = lid.status_id;
    });
});

function updateLidsCount(status_id) {
    switch (status_id[0]) {
        case 1:
        newLidCount.value += 1;
        break;
        case 2:
        inProgressLidCount.value += 1;
        break;
        case 3:
        completedLidCount.value += 1;
        break;
    }
    switch (status_id[1]) {
        case 1:
        newLidCount.value -= 1;
        break;
        case 2:
        inProgressLidCount.value -= 1;
        break;
        case 3:
        completedLidCount.value -= 1;
        break;
    }
}

function sendPostRequest(lidId, selectedStatusId) {
    axios.patch('/lid/edit/status', {
        id: lidId,
        status_id: selectedStatusId
    })
        .then(response => {
            // console.log('Success:', response.data);
            updateLidsCount(response.data);
        })
        .catch(error => {
            // console.error('Error:', error);
        });
}
</script>

<template>

    <Head title="Лиды" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Лиды</h2>
        </template>

        <Li>
            <li class="ps-3 pb-3">Количество лидов: {{ lidsCount }}</li>
            <li class="ps-3 pb-3">Количество лидов со статусом "Новый": {{ newLidCount }}</li>
            <li class="ps-3 pb-3">Количество лидов со статусом "В работе": {{ inProgressLidCount }}</li>
            <li class="ps-3">Количество лидов со статусом "Завершен": {{ completedLidCount }}</li>
        </Li>

        <ul v-for="lid in lids" :key="lid.id" class="text-xl">
            <Li>
                <li class="ps-3 pb-3">Имя: {{ lid.first_name }}</li>
                <li class="ps-3 pb-3">Фамилия: {{ lid.last_name }}</li>
                <li class="ps-3 pb-3">Телефон: {{ lid.phone }}</li>
                <li class="ps-3 pb-3">Email: {{ lid.email }}</li>
                <div>
                    <select v-model="lid.selectedStatusId" @change="sendPostRequest(lid.id, lid.selectedStatusId)" class="ml-3 text-xl">
                        <option v-for="statusOption in status" :key="statusOption.id" :value="statusOption.id">
                            Статус: {{ statusOption.name }}
                        </option>
                    </select>
                </div>
                <a :href="`/lids/edit/${lid.id}`">
                    <PrimaryButton class="mt-4 ml-3">Редактировать</PrimaryButton>
                </a>
                <form @submit.prevent="Inertia.delete('/lid/delete/' + lid.id)">
                    <PrimaryButton class="mt-4 ml-3">Удалить</PrimaryButton>
                </form>
            </Li>
        </ul>

    </AuthenticatedLayout>

</template>

<style>

</style>
