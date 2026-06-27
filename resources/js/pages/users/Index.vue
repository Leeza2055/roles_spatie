<script setup lang="ts">
import { Link, Head } from '@inertiajs/vue3';
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
</script>

<template>
    <Head title="Users List" />
    <h1 class="sr-only">Users List</h1>
    <Button as-child class="bg-blue-500 w-fit mt-4 ml-4 float-right">
        <Link :href="create()">Create a new user</Link>
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
                    <TableCell>{{ user.role_name.toString() }}</TableCell>
                    <TableCell>
                        <Button as-child class="bg-yellow-400">
                            <Link :href="edit(user.id)">Edit</Link>
                        </Button>

                        <Button as-child class="bg-red-500 ml-2">
                            <Link :href="destroy(user.id)">Destroy</Link>
                        </Button>
                    </TableCell>
                </TableRow>
            </TableBody>
        </Table>
    </div>
</template>
