<?php
    require_once("inc/header.php");
    require_once("inc/navigation.php");
?>

<div class="row my-3">
    <div class="col-12">
        <h3> Voters Panel </h3>

        <?php
            $fetchingActiveElection = mysqli_query($db, "SELECT * FROM elections WHERE status= 'Active' ") or die(mysqli_query($db));
            $totalActiveElections = mysqli_num_rows($fetchingActiveElection);

            if($totalActiveElections > 0)
            {
                while($data= mysqli_fetch_assoc($fetchingActiveElection))
                {
                    $election_id = $data['id'];
                    $election_topic = $data['election_topic'];
        ?>
                    <table class="table">
                        <thead>
                            <tr> 
                                <th colspan="4" class="bg-green text-white"> <H5>ELECTION TOPIC: <?php echo strtoupper($election_topic); ?> </H5> </th>
                            </tr>
                            <tr> 
                                <th>Photo </th>
                                <th>Candidate Details </th>
                                <th># of Votes </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody> 
        <?php
                            $fetchingCandidates = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id= '".$election_id."'") or die(mysqli_error($db));

                            while($candidateData = mysqli_fetch_assoc($fetchingCandidates))
                            {
                                $candidate_id = $candidateData['id'];
                                $candidate_photo = $candidateData['candidate_photo'];

                                //fetching candidate votes
                                $fetchingVotes = mysqli_query($db, "SELECT * FROM votings WHERE candidate_id = '".$candidate_id."'") or die(mysqli_error($db));
                                $totalVotes = mysqli_num_rows($fetchingVotes);
    
        ?>                      
                                <tr> 
                                    <td><img src="<?php echo $candidate_photo; ?>" style="width: 80px; height: 80px; border-radius: 50%;"/> </td>
                                    <td><?php echo "<b>" . $candidateData ['candidate_name']. "</b><br/>" . $candidateData['candidate_details']; ?> </td>
                                    <td><?php echo $totalVotes   ?> </td>
                                    <td>
                                    <?php    
                                        $checkIfVoteCasted = mysqli_query($db, "SELECT * FROM votings WHERE voters_id = '".$_SESSION['user_id']."' AND election_id = '".$election_id."' ") or die(mysqli_error($db));
                                        $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);

                                        if( $isVoteCasted > 0)
                                        {
                                            $voteCAstedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                            $voteCastedToCandidate = $voteCAstedData['candidate_id'];
                                            
                                            if($voteCastedToCandidate == $candidate_id) {
                                    ?>        
                                                "VOTED"
                                   <?php   
                                            }         
                                        }else {
                                    ?>
                                            <button class="btn btn-md btn-success" onclick = "CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>, <?php echo $_SESSION['user_id']; ?>)" > Vote </button>
                                    <?php
                                        }
                                    
                                    ?>
                                    </td>
                                </tr>

        <?php
                            }
        ?>
    
                        </tbody>
                    </table>
        <?php
                }

            }else {
                echo "No any active elections.";
            }
        ?>
    </div>
</div>

<script>
    const CastVote = (election_id, candidate_id, voters_id) =>
    {
       $.ajax({
        type : "POST",
        url : "inc/ajaxCall.php" ,
        data : "e_id=" + election_id + "&c_id=" + candidate_id + "&v_id=" + voters_id ,
        success : function(response) {
           if(response == "Success"){
            location.assign("index.php?voteCasted=1");
           } else {
            location.assign("index.php?voteNotCasted=1");
           }
        }
       });
    }

</script>




<?php
    require_once("inc/footer.php");
?>