<?php if(count( $questions )) : ?>
    <ul>
        <?php foreach($questions as $question) : ?>
            <li>
                <?php

                $post = $question->getPost();

                echo sprintf(
                    '<span class="dashicons dashicons-format-status"></span>&nbsp;<a href="%s"><strong>%s</strong> op %s om %s</a>',
                    esc_url( add_query_arg( array( 'post' => $question->getId(), 'action' => 'edit' ), 'post.php' ) ),
                    esc_html( sanitize_term_field( 'name', $question->getName(), $question->getId(), 'name', 'display' ) ),
                    esc_html( sanitize_term_field( 'date', date( 'd-m-Y', strtotime( $post->post_date ) ), $question->getId(), 'date', 'display' ) ),
                    esc_html( sanitize_term_field( 'time', date( 'H:i', strtotime( $post->post_date ) ), $question->getId(), 'time', 'display' ) )
                );

                ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else : ?>
    <p>Er zijn nog geen vragen gesteld.</p>
<?php endif; ?>