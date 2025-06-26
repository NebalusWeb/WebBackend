<?php

namespace Nebalus\Webapi\Config\Types;

class PermissionNodesTypes
{
    public const string ADMIN = 'admin';
    public const string ADMIN_ROLE = 'admin.role';
    public const string ADMIN_ROLE_CREATE = 'admin.role.create';
    public const string ADMIN_ROLE_EDIT = 'admin.role.edit';
    public const string ADMIN_ROLE_DELETE = 'admin.role.delete';

    public const string FEATURE = 'feature';
    public const string FEATURE_REFERRAL = 'feature.referral';
    public const string FEATURE_REFERRAL_OWN = 'feature.referral.own';
    public const string FEATURE_REFERRAL_OWN_CREATE = 'feature.referral.own.create';
    public const string FEATURE_REFERRAL_OWN_CREATE_LIMIT = 'feature.referral.own.view.limit';
    public const string FEATURE_REFERRAL_OWN_DELETE = 'feature.referral.own.delete';
    public const string FEATURE_REFERRAL_OWN_EDIT = 'feature.referral.own.edit';
    public const string FEATURE_REFERRAL_OWN_ENABLED = 'feature.referral.own.enabled';
    public const string FEATURE_REFERRAL_OTHER = 'feature.referral.other';
    public const string FEATURE_REFERRAL_OTHER_DELETE = 'feature.referral.other.delete';
    public const string FEATURE_REFERRAL_OTHER_EDIT = 'feature.referral.other.edit';
    public const string FEATURE_REFERRAL_OTHER_SEE = 'feature.referral.other.see';
}
