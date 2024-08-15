<script setup>
import {onMounted, ref} from "vue";
import axios from 'axios';
import {useRoute, useRouter} from "vue-router";

const route = useRoute();
const router = useRouter();

const person = ref(null);

const fetchPerson = async (id) => {
    try {
        const response = await axios.get(`/api/people/${id}`);
        person.value = response.data.data;
    } catch (error) {
        console.error('Error occurred while trying to fetch person: ', error);
    }
};

const updatePerson = async () => {
    try {
        const response = await axios.put(`/api/people/${person.value.id}`, person.value);
        await router.push({name: 'people'});
    } catch (error) {
        console.error('Error occurred while trying to update person: ', error);
    }
};

const genderOptions = ref([
    {text: 'muž', value: '1'},
    {text: 'žena', value: '2'},
]);

onMounted(() => {
    const id = route.params.id;
    fetchPerson(id);
});
</script>

<template>
    <h1 class="mb-4">Osoba</h1>
    <form v-if="person">
        <div class="row mb-4">
            <div class="col-lg-6 col-md-12">
                <label for="id" class="form-label">ID:</label>
                <input type="number"
                       class="form-control"
                       id="id"
                       :value="person.id"
                       disabled
                >
            </div>
            <div class="col-lg-6 col-md-12">
                <label for="name" class="form-label">Meno:</label>
                <input type="text"
                       class="form-control"
                       id="name"
                       v-model="person.name"
                >
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-6 col-md-12">
                <label for="age" class="form-label">Vek:</label>
                <input type="number"
                       class="form-control"
                       id="age"
                       v-model="person.age"
                >
            </div>
            <div class="col-lg-6 col-md-12">
                <label for="gender" class="form-label">Pohlavie:</label>
                <select id="gender" class="form-select" aria-label="Výber pohlavia" v-model="person.gender">
                    <option v-for="option in genderOptions" :value="option.value">
                        {{ option.text }}
                    </option>
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-primary" @click="updatePerson">Uložiť</button>
    </form>
</template>

<style scoped>

</style>
