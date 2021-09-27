<template>
    <div class="grid grid-cols-2 gap-4">
        <div>
            <div class="ml-3">
                <form class="flex flex-col md:flex-row">
                    <label
                        class="block text-gray-700 text-sm font-bold pt-3 mb-2"
                        for="username"
                    >
                        Title
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full ml-2 mr-2 l py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        type="text"
                        v-model="name"
                    />

                    <label
                        class="block text-gray-700 text-sm font-bold pt-2 mb-2"
                        for="username"
                    >
                        Assign To
                    </label>
                    <select
                        class="block appearance-none w-full ml-2 mr-2 bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        v-model="user_id"
                    >
                        <option
                            v-for="option in users"
                            v-bind:value="option.id"
                            :key="option.id"
                        >
                            {{ option.name }}
                        </option>
                    </select>
                    <button
                        v-on:click="triggerFunction()"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        type="button"
                    >
                        Save
                    </button>
                </form>
            </div>
            <div class="content-center flex justify-center mt-3">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>#</th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Name
                            </th>
                            <th
                                scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                            >
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <tr v-for="row in todolist" :key="row.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input
                                    type="checkbox"
                                    :value="row.id"
                                    :id="row.id"
                                    v-model="selected"
                                    @change="completedTodo($event, row)"
                                />
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="ml-4">
                                        <div
                                            class="text-sm font-medium text-gray-900"
                                            :class="
                                                row.status == 1
                                                    ? 'line-through'
                                                    : ''
                                            "
                                        >
                                            {{ row.title }} -
                                            {{ row.user.name }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                            >
                                <!-- <a href="#" v-on:click="editData(row,$event)" class="text-indigo-600 hover:text-indigo-900">Edit</a>&nbsp;&nbsp; -->
                                <a
                                    href="#"
                                    v-on:click="destoryData(row, $event)"
                                    class="text-indigo-600 hover:text-indigo-900"
                                    >X</a
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div>
          <h2 class="text-lg">Assigned Task to User</h2>
          <table  class="min-w-full divide-y divide-gray-200 mt-9">
            <thead class="bg-gray-50">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Of Task Assigned</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="user in assignedUsers" :key="user.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{user.name}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{user.email}}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">{{user.todos.length}}</td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
</template>

<script>
export default {
    props: ["users"],
    data() {
        return {
            name: "",
            update: "",
            user_id: "",
            todolist: [],
            assignedUsers:[],
            selected: []
        };
    },
    mounted() {
        this.loadData();
    },
    methods: {
        loadData() {
            axios
                .get("/todolist")
                .then(response => {
                    this.todolist = response.data.todolist;
                    this.selected = this.todolist
                        .filter(obj => obj.status == 1)
                        .map(obj => obj.id);
                    this.assignedUsers = response.data.users;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        triggerFunction() {
            if (this.update) {
                this.updateData();
            } else {
                this.saveData();
            }
        },
        saveData() {
            axios
                .post("/store/todo", {
                    title: this.name,
                    user_id: this.user_id
                })
                .then(response => {
                    this.loadData();
                    this.name = "";
                    this.user_id = "";
                })
                .catch(error => {
                    console.log(error);
                });
        },
        updateData() {
            axios
                .post("/update/" + this.update + "/todo", {
                    title: this.name,
                    user_id: this.user_id
                })
                .then(response => {
                    this.loadData();
                    this.name = "";
                    this.user_id = "";
                })
                .catch(error => {
                    console.log(error);
                });
        },
        editData(todo) {
            this.name = todo.title;
            this.update = todo.id;
            this.user_id = todo.user.id;
        },
        destoryData(todo, event) {
            event.preventDefault();
            axios
                .post("/delete/todo", {
                    id: todo.id
                })
                .then(response => {
                    this.loadData();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        completedTodo(event, todo) {
            console.log(todo);
            console.log(event);
            axios
                .post("/status/todo", todo)
                .then(response => {
                    console.log(response);
                    this.loadData();
                })
                .error(error => {
                    console.log(error);
                });
        }
    }
};
</script>
