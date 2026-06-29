<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { create, store } from '@/routes/users';


defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Create a new User',
                href: create(),
            },
        ],
    },
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    roles: ''
});

function submit() {
    form.post(store().url);
} 
</script>

<template>
    <Head title="Create a new User" />
    <div class="p-8">
        <form @submit.prevent="submit">
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-heading">Name</label>
                <input v-model="form.name" type="text" id="name" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" placeholder="" />
                <p v-if="form.errors.name" class="text-sm text-red-500 mt-0.5">{{ form.errors.name }}</p>
            </div>

            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-heading">Email</label>
                <input v-model="form.email" type="text" id="email" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" placeholder="" />
                <p v-if="form.errors.email" class="text-sm text-red-500 mt-0.5">{{ form.errors.email }}</p>
            </div>

            <div class="mb-4">
                <label for="password" class="block mb-2 text-sm font-medium text-heading">Password</label>
                <input v-model="form.password" type="password" id="password" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-2.5 py-2 shadow-xs placeholder:text-body" placeholder="" />
                <p v-if="form.errors.password" class="text-sm text-red-500 mt-0.5">{{ form.errors.password }}</p>
            </div>
            
            <div class="mb-4">
                <label for="roles" class="block mb-2.5 text-sm font-medium text-heading">Select a role</label>
                <select id="roles" v-model="form.roles" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option selected>Choose a role</option>
                    <option value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="viewer">Viewer</option>
                </select>
                <p v-if="form.errors.roles" class="text-sm text-red-500 mt-0.5">{{ form.errors.roles }}</p>
            </div>

             <Button type="submit" class="mb-5">
                Create User
            </Button> 

        </form>
    </div>
</template>
