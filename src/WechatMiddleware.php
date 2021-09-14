<?php
declare (strict_types=1);

namespace Larva\Wechat;

use Closure;
use EasyWeChat\OfficialAccount\Application;
use think\facade\Event;
use think\facade\Session;
use think\Request;

/**
 * 认证中间件
 */
class WechatMiddleware
{
    /**
     * 执行中间件.
     * @param Request $request
     * @param Closure $next
     * @param null $param
     * @return mixed|\think\response\Redirect
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Overtrue\Socialite\Exceptions\AuthorizeFailedException
     */
    public function handle(Request $request, Closure $next, $param = null)
    {
        $params = $this->getParam($param);

        $account = $params['account'];
        $scope = $params['scope'];

        //定义session
        $sessionKey = 'wechat_oauth_user_' . $account;

        /* @var Application $officialAccount */
        $officialAccount = app(\sprintf('wechat.official_account.%s', $account));
        $scope = $scope ?? config(\sprintf('wechat.official_account.%s.oauth.scopes', $account), ['snsapi_base']);
        if (is_string($scope)) {
            $scope = array_map('trim', explode(',', $scope));
        }

        if (Session::has($sessionKey)) {
            Event::trigger(new WeChatUserAuthorized(Session::get($sessionKey), false, $account));
            return $next($request);
        }

        if ($request->has('code')) {
            $user = $officialAccount->oauth->userFromCode($request->get('code'));
            Session::set($sessionKey, $user);
            Event::trigger(new WeChatUserAuthorized($user, true, $account));
            return redirect($this->getTargetUrl($request));
        }
        Session::delete($sessionKey);

        // 跳转到微信授权页
        $url = $officialAccount->oauth->scopes($scope)->redirect($request->url(true));
        return redirect($url);
    }

    /**
     * @param $params
     * @return array
     */
    protected function getParam($params): array
    {
        //定义初始化
        $res = [
            'account' => 'default',
            'scope' => null,
        ];
        if (!$params) {
            return $res;
        }
        //解析
        $result = explode(':', $params);
        $account = '';
        $scopes = '';
        if (isset($result[0])) {
            $account = $result[0];
        }
        if (isset($result[1])) {
            $scopes = $result[1];
        }
        if ($account) {
            if (strstr($account, 'sns')) {
                $res['scope'] = $account;
            } else {
                $res['account'] = $account;
            }
        }
        if ($scopes) {
            $res['scope'] = $scopes;
        }
        return $res;
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *¬
     * @return string
     */
    protected function getTargetUrl(Request $request): string
    {
        $param = $request->except(['code', 'state']);
        return $request->baseUrl() . (empty($param) ? '' : '?' . http_build_query($param));
    }
}