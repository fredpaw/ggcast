<template>
	<div class="container">
		<h1 class="text-center">
			<button class="btn btn-primary" @click="createNewLesson()">
				Create New Lesson
			</button>
		</h1>
		<ul class="list-group">
			<li class="list-group-item d-flex justify-content-between" v-for="Lesson, key in lessons">
				<p>{{ Lesson.title }}</p>
				<p>
					<button class="btn btn-primary btn-xs" @click="editLesson(Lesson)">
						Edit
					</button>
					<button class="btn btn-danger btn-xs" @click="deleteLesson(Lesson.id, key)">
						Delete
					</button>
				</p>
			</li>
		</ul>
		<create-lesson></create-lesson>
	</div>
</template>

<script>
	import Axios from 'axios';

	export default {
		props: ['default_lessons', 'series_id'],

		mounted() {
			this.$on('lesson_created', (lesson) => {
				window.noty({
					message: 'Lesson created successfully',
					type:'success'
				});
				this.lessons.push(lesson);
			}),

			this.$on('lesson_updated', (lesson) => {
				let lessonIndex = this.lessons.findIndex(l => {
					return lesson.id == l.id
				});

				this.lessons.splice(lessonIndex, 1, lesson);
			})
		},

		components: {
			"create-lesson": require('./children/CreateLesson.vue')
		},

		data() {
			return {
				lessons: JSON.parse(this.default_lessons),
			}
		},

		computed: {
			
		},

		methods: {
			createNewLesson() {
				this.$emit('create_new_lesson', this.series_id)
			},

			deleteLesson(id, key) {
				if(confirm('Are you sure you wanna delete?')) {
					Axios.delete(`/admin/${this.series_id}/lessons/${id}`)
							 .then(resp => {
							 		console.log(resp);
							 		this.lessons.splice(key, 1);
							 		window.noty({
							 			message: 'Lesson deleted!',
							 			type: 'success'
							 		})
							 })
							 .catch(error=> {
							 		console.log(error);
							 })
				}
			},

			editLesson(lesson) {
				let seriesId = this.series_id
				this.$emit('edit_lesson', {lesson, seriesId});
			}
		}
	}
</script>