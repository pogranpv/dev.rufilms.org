<div class="opros">
    <div class="vse">
			<form method="post" name="vote_result" action=''>
				<input type="hidden" name="vote_action" value="results" />
				<input type="hidden" name="vote_id" value="{vote_id}" />
				<button class="vresult" type="submit" onclick="ShowAllVotes(); return false;" >���</button>
			</form>
	</div><br />
	<span style="font: 18px Arial, Helvetica, sans-serif;">�����</span>		
		<div class="opr">
		<b>{title}</b><br />
		<div class="dpad">
			[votelist]<form method="post" name="vote" action=''>[/votelist]
			{list}
			<br />
			[voteresult]<div><small>����� �������������: {votes}</small></div>[/voteresult]
			[votelist]
				<input type="hidden" name="vote_action" value="vote" />
				<input type="hidden" name="vote_id" id="vote_id" value="{vote_id}" />
				<button class="fbutton voteb" type="submit" onclick="doVote('vote'); return false;" >����������</button>&nbsp;<button class="fbutton voteb" type="button" onclick="doVote('results'); return false;" >����������</button>
			</form>
			[/votelist]
		</div></div>
	</div>