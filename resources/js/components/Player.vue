<template>
	<div>
		<div :data-vimeo-id="lesson.video_id" data-vimeo-width="900" v-if="lesson" id="handstick"></div>
	</div>
</template>

<script>
	import Player from '@vimeo/player';
	import Swal from 'sweetalert';
	import Axios from 'axios';

	export default {
		props: ['default_lesson', 'next_lesson_url'],

		data() {
			return {
				lesson: JSON.parse(this.default_lesson)
			}
		},

		methods: {
			displayVideoEndedAlert() {
				if(this.next_lesson_url){
					Swal('You have finished this lesson.')
						.then(() => {
							window.location = this.next_lesson_url;
						});
				} else {
					Swal('Congratulations, You finished the series!');
				}
			},

			completeLesson() {
				Axios.post(`/series/complete_lesson/${this.lesson.id}`, {})
						 .then(resp => {
						 		this.displayVideoEndedAlert();
						 })
			}
		},

		mounted() {
			const player = new Player('handstick');

			player.on('ended', () => {
				this.completeLesson();
			});
		}
	}
</script>