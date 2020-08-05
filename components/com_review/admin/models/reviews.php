<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_review
 * 
 * 
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * ReviewsList Model
 * 
 * @since   0.0.1
 */
class ReviewModelReviews extends JModelList
{
    /**
     * Constructor
     * 
     * @param   array   $config An optional associative array of configuration options, contains the possible sorting column names
     * 
     * @see     JController
     * @since   1.6
     */
    public function __construct($config = array())
    {
        if(empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id',
                'aid',
                'uid',
                'updated',
                'rating',
                'review',
                'published'
            );
        }

        parent::__construct($config);
    }
    
    /**
     * Method to build an SQL query to load the list data
     * 
     * @return  string  An SQL query
     */
    protected function getListQuery()
    {
        // Init variables
        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);

        // Create the base select statement
        $query
            ->select('*')
            ->from($db->quoteName('reviews'));

        // Filter: like / search
        $search = $this->getState('filter.search');

        if(!empty($search))
        {
            // Check for specific article id search
            if(preg_match('/^aid:.*/', strtolower($search)))
            {
                $like = $db->quote(substr($search, 4));
                $query->where('aid = ' . $like);
            } // Check for specific user id search
            else if(preg_match('/^uid:.*/', strtolower($search)))
            {
                $like = $db->quote(substr($search, 4));
                $query->where('uid = ' . $like);
            } // Check the text fields for review
            else
            {
                $like = $db->quote('%' . $search . '%');
                $query->where('review LIKE ' . $like);
            }
        }

        // Filter by published state
        $published = $this->getState('filter.published');

        if(is_numeric($published))
        {
            $query->where('published = ' . (int) $published);
        }
        elseif ($published === '')
        {
            $query->where('(published IN (0, 1))');
        }

        // Add the list ordering clause
        $orderCol   = $this->state->get('list.ordering', 'aid');
        $orderDirn  = $this->state->get('list.direction', 'asc');

        $query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

        /* $debug_order = "orderCol: $orderCol\\norderDirn: $orderDirn";
        JFactory::getDocument()->addScriptDeclaration(
            'console.log("' . $debug_order . '")'
        ); */

        return $query;
    }
}