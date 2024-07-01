<?php 
    $election_id =$_GET['viewResult'];
?>


<div class="row my-3">
    <div class="col-12">
        <h3> Election Results </h3>

        <?php
            $fetchingActiveElection = mysqli_query($db, "SELECT * FROM elections WHERE id= '".$election_id."' ") or die(mysqli_query($db));
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
                                <!-- <th> Actions </th> -->
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

        <hr>
        <h3>Voting Result</h3>
            <?php
                $fetchingVoteDetails = mysqli_query($db, "SELECT * FROM votings WHERE election_id = '".$election_id."' ") OR die(mysqli_error($db));
                $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                if($number_of_votes > 0)
                {
                    $sno =1;
            ?>        
                    <table class="table">
                    <tr> 
                        <th>S.no </th>
                        <th>Voter Name </th>
                        <th>Contact No </th>
                        <th>Voted To </th>
                        <th>Date </th>
                        <th>Time </th>
                    </tr> 
            <?php         
                    while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                    {
                        $voters_id = $data['voters_id'];
                        $candidate_id = $data['candidate_id'];
                        $fetchingUsername = mysqli_query($db, "SELECT * FROM user WHERE id = '".$voters_id."'") or die(mysqli_error($db));
                        $isDataAvailable = mysqli_num_rows($fetchingUsername);
                        $userData = mysqli_fetch_assoc($fetchingUsername);
                        if($isDataAvailable >0)
                        {
                            $username = $userData['username'];
                            $contact_no = $userData['contact_no'];
                        }else {
                            $username = "No_Data";
                            $contact_no= "No_Data";
                        }

                        $fetchingCandidateName = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '".$candidate_id."'") or die(mysqli_error($db));
                        $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                        $userData = mysqli_fetch_assoc($fetchingCandidateName);
                        if($isDataAvailable >0)
                        {
                            $candidatae_name = $userData['candidate_name'];
                        }else {
                           $candidatae_name ="No_Data";
                        }
            ?>
                        <tr> 
                            <td><?php echo $sno++; ?> </td>
                            <td><?php echo $username;?></td>
                            <td><?php echo $contact_no;?> </td>
                            <td><?php echo $candidatae_name;?>  </td>
                            <td><?php echo $data['vote_date']?> </td>
                            <td><?php echo $data['vote_time'];?> </td>
                        </tr>
            <?php

                    }
                }else {
                    echo "No any vote details are avialable.";
                }
            ?>
        </table>

    </div>
</div>