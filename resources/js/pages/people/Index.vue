<script setup>
import {onMounted, ref, watch} from "vue";
import axios from 'axios';
import lodash from 'lodash';
import {useRoute, useRouter} from "vue-router";

const route = useRoute();
const router = useRouter();

const people = ref([]);
const search = ref('');

const fetchPeople = async () => {
    try {
        const response = await axios.get('/api/people', {
            params: {search: search.value}
        });
        people.value = response.data.data;
    } catch (error) {
        console.error('Error occurred while trying to fetch people: ', error);
    }
};

const deletePerson = async (id) => {
    try {
        const response = await axios.delete(`/api/people/${id}`);
        await fetchPeople();
    } catch (error) {
        console.error('Error occurred while trying to update person: ', error);
    }
};

const updatePeopleList = lodash.debounce((query) => {
    router.push({ query: { search: query } });
}, 500);

watch(() => route.query.search, (newSearch) => {
    search.value = newSearch || '';
    fetchPeople();
});

onMounted(() => {
    fetchPeople();
});
</script>

<template>
    <h1 class="mb-4">Osoby</h1>
    <input
        type="text"
        class="form-control mb-4"
        placeholder="Hľadať..."
        v-model="search"
        @input="updatePeopleList(search)"
    />
    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Meno</th>
            <th scope="col">Vek</th>
            <th scope="col">Pohlavie</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="person in people" :key="person.id">
            <th scope="row">{{ person.id }}</th>
            <td>{{ person.name }}</td>
            <td>{{ person.age }}</td>
            <td>{{ person.genderTitle }}</td>
            <td class="d-flex justify-content-end gap-2">
                <RouterLink :to="{name: 'people-edit', params: {id: person.id}}"
                            class="btn btn-primary text-white py-0"
                >Upraviť
                </RouterLink>
                <button @click="deletePerson(person.id)" type="button" class="btn btn-danger py-0">Odstrániť</button>
            </td>
        </tr>
        </tbody>
    </table>
</template>
