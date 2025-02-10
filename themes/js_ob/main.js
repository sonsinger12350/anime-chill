function onlineReward() {
	if (!$user.id) return false;
	axios.post('/server/api', {
		"action": "online_reward",
		"token": $dt.token
	}).then(reponse => {
		if (reponse.data.success) {
			Toast({
				message: reponse.data.message,
				type: "success"
			});
		}
	}).catch(e => run_ax = true)
}

$(document).ready(function() {
	onlineReward();
	setInterval(() => {
		onlineReward();
	}, 60000);
});