<?php

/**
 * Extension of Inclusion, because InclusionIn only accepts flat arrays
 * http://forum.phalconphp.com/discussion/3129/use-form-validator-inclusionin-with-model-
 *
 * This way in the form you can use the same pull for both building a select and validating it.  Like so:
 *
 * $job = new Element\Select('job_id', $web_user->model->getJobs('visible > 0'), array('using'=>array('job_id', 'job_title')));
 * $job->addValidators(array(
 * 		new EveValidator\ModelIn(array('message' => 'job error', 'domain' => $web_user->model->getJobs(array('visible > 0')), 'using' => array('job_id'), 'allowEmpty' => false)),
 * ));
 *
 *
 * @param $options["domain"] 	- the result set
 * @param $options["using"]		- the property from each result that is used to build the values to check against in parent
 */

namespace Eve\Validator;

use Phalcon\Mvc\Model\Resultset;
use Phalcon\Validation\Validator\InclusionIn;

class ModelIn extends InclusionIn {

    public function __construct($options=null) {


        //if 'using' is set, use it to pull values out of the result set
        if(
            isset($options['domain'])
            && isset($options['using'])
            && ($options['domain'] instanceof Resultset)
        ) {

            $domain = array();

            foreach($options['domain'] as $d) {
                foreach((array)$options['using'] as $u) {
                    if(isset($d->$u)) {
                        $domain[] = $d->$u;
                    }
                }
            }

            $options['domain'] = $domain;
            unset($options['using']);
        }

        return parent::__construct($options);
    }

}