<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import { index, update } from '@/routes/users';
import type { User } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Index',
                href: index(),
            },
            {
                title: 'Edit',
                href: '#',
            },
        ],
    },
});

const props = defineProps<{ user: User }>();

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    roles: props.user.role_name
});
const page = usePage();
const role_name = page.props.roles[0];

function submit() {
    form.put(update(props.user.id).url);
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
                <label for="roles" class="block mb-2.5 text-sm font-medium text-heading">Select a role</label>
                <select id="roles" v-model="form.roles" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                    <option value="" disabled>Choose a role</option>
                    <option v-if="role_name === 'super_admin'" value="super_admin">Super Admin</option>
                    <option value="admin">Admin</option>
                    <option value="viewer">Viewer</option>
                </select>
            </div>

             <Button type="submit" class="mb-5">
                Edit User
            </Button> 

        </form>
    </div>
</template>
