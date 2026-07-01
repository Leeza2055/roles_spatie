<script setup lang="ts">
import { Link, Head, useForm, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button'
import {
    Table,
    TableBody,
    TableCaption,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table'
import { index, create, edit, destroy } from '@/routes/users';
import type { User } from '@/types';

const form = useForm({});

const handleDelete = (id: number) => {
    if (confirm('Do you want to delete the user?')) {
       form.delete(destroy(id).url);
    }
}

defineOptions({
    layout: {
        breadcrumbs: [
            {
                title: 'Users List',
                href: index(),
            },
        ],
    },
});

defineProps<{
    users: User[];
}>();

const page = usePage();
const auth_user = page.props.auth.user;
const role_name = page.props.roles[0];

</script>

<template>
    <Head title="Users List" />
    <h1 class="sr-only">Users List</h1>
    <Button as-child class="bg-blue-500 w-fit mt-4 ml-4 float-right">
        <Link :href="create()">Create a new User</Link>
    </Button>
    <div class="p-8">
        <Table>
            <TableCaption>A list of users.</TableCaption>
            <TableHeader>
                <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead>Role</TableHead>
                    <TableHead>Actions</TableHead>
                </TableRow>
            </TableHeader>
            <TableBody v-for="user in users" :key="user.id">
                <TableRow>
                    <TableCell>{{ user.name }}</TableCell>
                    <TableCell>{{ user.email }}</TableCell>
                    <TableCell>{{ user.role_name }}</TableCell>
                    <TableCell>
                        <Button as-child class="bg-yellow-400">
                            <Link :href="edit(user.id)">Edit</Link>
                        </Button>
                        <Button @click="handleDelete(user.id)" class="bg-red-500 ml-2">{{ form.processing ? 'Deleting' : 'Delete' }}</Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
